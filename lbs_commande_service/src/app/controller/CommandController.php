<?php

namespace lbs\command\app\controller;

use Exception;
use lbs\command\app\models\Command;
use lbs\command\app\models\Item;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use lbs\command\app\utils\JsonResponse;
use Ramsey\Uuid\Uuid;
use \Datetime;

class CommandController
{
    private $c;

    public function __construct(\Slim\Container $c)
    {
        $this->c = $c;
    }

    /**
     * Get all commandes
     */
    function listcommandes(Request $req, Response $res, array $args): Response
    {
        $commandes = Command::all();

        $data = [
            'type' => 'collection',
            "count" => count($commandes),
            "commandes" => $commandes,
        ];

        //Build response
        $jsonResp = new JsonResponse;
        return $jsonResp->buildResp($req, $res, 200, $data);
    }

    /**
     * Get commande by id
     */
    function oneCommand(Request $req, Response $res, array $args): Response
    {
        try {
            //Get token from req
            $token = $req->getAttribute('token');

            //Search for commande
            $commande = Command::where([
                ['id', $args['id']],
                ['token', $token]
            ])->firstOrFail();

            //Format commande result (depending on TD requiment)
            $commandFormated = array(
                "id" => $commande->id,
                "mail" => $commande->mail,
                "nom" => $commande->nom,
                "date_commande" => $commande->created_at,
                "date_livraison" => $commande->livraison,
                "montant" => $commande->montant,
            );

            //Check if items is required by the client (attach it to commande if exist)
            if ($req->getQueryParams('embed') && $req->getQueryParams('embed')['embed'] == "items") {
                $commandFormated['items'] = $commande->items()->select('id', 'libelle', 'tarif', 'quantite')->get();
            }

            //Build the response data
            $data = [
                'type' => 'resource',
                'commande' => $commandFormated,
                'links' => array(
                    "items" => array(
                        "href" => $this->c->router->pathFor(
                            'commandeItems',
                            ['id' => $args['id']]
                        )
                    ),
                    "self" => array(
                        "href" => $this->c->router->pathFor(
                            'commande',
                            ['id' => $commande->id]
                        )
                    )
                )
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 200, $data);
        } catch (\illuminate\Database\Eloquent\ModelNotFoundException $th) {

            $data = [
                'type' => 'error',
                'error' => 404,
                'message' => "Ressource not found : commande ID = " . $args['id'] . " & token= " . $token
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 404, $data);
        }
    }

    /**
     * Get a commande items
     */
    function commandItems(Request $req, Response $res, array $args): Response
    {
        try {
            $commande = Command::findOrFail($args['id']);
            $data = [
                'type' => 'collection',
                'count' => count($commande->items),
                'items' => $commande->items()->select('id', 'libelle', 'tarif', 'quantite')->get(),
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 200, $data);
        } catch (\illuminate\Database\Eloquent\ModelNotFoundException $th) {

            $data = [
                'type' => 'error',
                'error' => 404,
                'message' => "Ressource not found : commande ID = " . $args['id']
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 404, $data);
        }
    }

    /**
     * Update commande by id
     */
    function updateCommande(Request $req, Response $res, array $args): Response
    {
        try {
            $commande = Command::findOrFail($args['id']);
            $data = [];
            $missing = [];

            //Check if param nom exist
            if (!isset($req->getParsedBody()['nom'])) {
                //Return error (synthaxe error)
                array_push($missing, "nom");
            }

            //Check if param email exist
            if (!isset($req->getParsedBody()['email'])) {
                //Return error (synthaxe error)
                array_push($missing, "email");
            }

            //Check if param delivery exist
            if (!isset($req->getParsedBody()['delivery'])) {
                //Return error (synthaxe error)
                array_push($missing, "delivery");
            }

            //In case error happend send the response
            if ($missing) {
                $missing = implode(",", $missing);
                $data = [
                    'type' => 'error',
                    'error' => 400,
                    'message' => "Missing or invalid param(s) $missing"
                ];

                //Build response
                $jsonResp = new JsonResponse;
                return $jsonResp->buildResp($req, $res, 400, $data);
            }

            //Filter data
            $nom = filter_var($req->getParsedBody()['nom'], FILTER_SANITIZE_STRING);
            $mail = filter_var($req->getParsedBody()['email'], FILTER_SANITIZE_EMAIL);
            $livraison = filter_var($req->getParsedBody()['delivery'], FILTER_SANITIZE_STRING);

            //Update commande
            $commande->nom = $nom;
            $commande->mail = $mail;
            $commande->livraison = $livraison;
            $commande->save();

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 204, []);
        } catch (\illuminate\Database\Eloquent\ModelNotFoundException $th) {
            //Ressource not found
            $data = [
                'type' => 'error',
                'error' => 404,
                'message' => "Ressource not found : commande ID = " . $args['id']
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 404, $data);
        }
    }

    /**
     * Add new commande
     */
    function addCommande(Request $req, Response $res, array $args): Response
    {
        try {
            //Check for validation errors
            if ($req->getAttribute('has_errors')) {
                $errors = $req->getAttribute('errors');
                $msg = "";
                foreach ($errors as $key => $e) {
                    $msg .= $key . ":" . implode(",   ", $e);
                }
                $data = [
                    'type' => 'error',
                    'error' => 403,
                    'message' => $msg
                ];

                //Build response
                $jsonResp = new JsonResponse;
                return $jsonResp->buildResp($req, $res, 403, $data);
            }

            //Filter data
            $nom = filter_var($req->getParsedBody()['nom'], FILTER_SANITIZE_STRING);
            $mail = filter_var($req->getParsedBody()['mail'], FILTER_SANITIZE_EMAIL);
            $date = filter_var($req->getParsedBody()['livraison']['date'], FILTER_SANITIZE_STRING);
            $heure = filter_var($req->getParsedBody()['livraison']['heure'], FILTER_SANITIZE_STRING);

            //Generate id
            $comId = Uuid::uuid4()->toString();

            //Generate token
            $token = random_bytes(32);
            $token = bin2hex($token);

            //Add items
            $total = 0;
            $items = $req->getParsedBody()['items'];
            foreach ($items as $key => $i) {
                $item = new Item();
                $item->uri = filter_var($i['uri'], FILTER_SANITIZE_STRING);
                $item->libelle = filter_var($i['libelle'], FILTER_SANITIZE_STRING);
                $item->tarif = filter_var($i['tarif'], FILTER_SANITIZE_STRING);
                $item->quantite = filter_var($i['q'], FILTER_SANITIZE_STRING);
                $item->command_id = $comId;
                $item->save();

                //Add to total
                $total += $i['tarif'] * $i['q'];
            }

            //Create commande
            $commande = new Command();
            $commande->id = $comId;
            $commande->nom = $nom;
            $commande->mail = $mail;
            $commande->livraison = (new DateTime($date . '' . $heure))->format('Y-m-d H:i:s');
            $commande->token = $token;
            $commande->montant = $total;
            $commande->save();

            //Format response
            $data = [
                'commande' => array(
                    "nom" => $commande->nom,
                    "mail" => $commande->mail,
                    "date_livraison" => $commande->livraison,
                    "id" => $commande->id,
                    "token" => $commande->token,
                    "montant" => $commande->montant,
                )
            ];

            //Build response
            $jsonResp = new JsonResponse;

            //Add location to header
            $res = $res->withHeader(
                'Location',
                $this->c->router->pathFor(
                    'commande',
                    ['id' => $commande->id]
                )
            );

            return $jsonResp->buildResp($req, $res, 201, $data);
        } catch (Exception $th) {
            //Ressource not found
            $data = [
                'type' => 'error',
                'error' => 500,
                'message' => "Ops! can't create new record"
            ];

            //Build response
            $jsonResp = new JsonResponse;
            return $jsonResp->buildResp($req, $res, 500, $data);
        }
    }
}
