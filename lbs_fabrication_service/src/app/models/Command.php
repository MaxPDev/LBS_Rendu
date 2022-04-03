<?php

namespace lbs\fab\app\models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
   protected $table = 'commande';

   protected $primaryKey = 'id';
   public $incrementing = false;
   public $keyType = 'string';

   protected $fillable = array(
      'id', 'livraison', 'nom', 'mail', 'montant', 'token', 'status'
   );


   //Command's items
   public function items()
   {
      return $this->hasMany('lbs\command\app\models\Item');
   }
}
