<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Caja extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_caja';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function caja()
    {
        return $this->belongsTo('App\Caja','id_caja');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User','id_usuario');
    }
}
