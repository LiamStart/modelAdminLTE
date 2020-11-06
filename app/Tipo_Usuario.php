<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Usuario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_usuario';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

}
