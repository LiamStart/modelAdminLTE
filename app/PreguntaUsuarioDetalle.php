<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaUsuarioDetalle extends Model
{
    protected $table = 'preguntas_usuario_detalle';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function detalle()
    {
        return $this->belongsTo('App\PreguntaDetalle','id_detalle','id');
    }
}
