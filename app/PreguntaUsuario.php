<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaUsuario extends Model
{
    protected $table = 'preguntas_usuario';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
