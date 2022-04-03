<?php

namespace lbs\command\app\models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    protected $primaryKey = 'id';

    protected $fillable = array(
        'id', 'uri', 'libelle', 'tarif', 'quantite', 'command_id'
    );

    public $timestamps = false;

    //Command
    public function command()
    {
        return $this->belongsTo('lbs\command\app\models\Command', 'command_id');
    }
}
