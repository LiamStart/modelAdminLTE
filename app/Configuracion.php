<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracion';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
