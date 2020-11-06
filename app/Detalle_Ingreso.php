<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Ingreso extends Model
{
            /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_ingreso';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
