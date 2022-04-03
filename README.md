# Le Bon Sandwich TD
Ce projet fait intéragir un service de prise de commande, un service de suivi de fabrication, un service catalogue et sa partie front-end, un service d'authentification, et une gateway.

## Membres du groupe:
- Youssef Bahi (youssef.bahi1@etu.univ-lorraine.fr)
- Malek Ben Khalifa (malek.ben-khalifa3@etu.univ-lorraine.fr)
- Sebastien Klaus (sebastien.klaus2@etu.univ-lorraine.fr)
- Maxime Piscalgia (maxime.piscaglia1@etu.univ-lorraine.fr)
- Armand Perignon (armand.perignon3@etu.univ-lorraine.fr)

## Lien utiles:
- Documentation : https://lbs-docs.netlify.app/
- Tableau de bord (Trello) : https://trello.com/b/c0v6nGKE/tableau-de-bord

## Code source :
- https://github.com/MaxPDev/LBS_Rendu

## Installation:

```
docker-compose up --no-start
```

```
docker-compose start
```

**Note : dans chaque container de ce réseau docker, il faut excécuter cette commande :**
```
docker exec -it nom_du_container /bin/bash
```
```
composer install
```

## Ports (en local) :
- Service de commande : **19080**
- Service de fabrication : **19680**
- Service d'administration des données (Adminer) : **8080**
- Service d'authentification' : **19980** 
- Service de catalogue : **19055**
- Service wrapper du catalogue : **19880**
- Service backoffice : **20080**

## Technologies :
- Services de commande, fabrication, authentification et backoffice : Slim 3
- Service Catalogue : Directus 9
- Wrapper du catalogue : Twig
- Database : Adminer + Sql
