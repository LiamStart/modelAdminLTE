<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_Detalle_Caja extends Model
{
          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_detalle_caja';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
