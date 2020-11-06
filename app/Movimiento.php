<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movimiento';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'id_producto');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuariocrea','ci');
    }
}
