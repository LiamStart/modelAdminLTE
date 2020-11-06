<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaDetalle extends Model
{
    protected $table = 'preguntas_detalle';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function cabecera()
    {
        return $this->belongsTo('App\PreguntaCabecera','id_cabecera','id');
    }
}
