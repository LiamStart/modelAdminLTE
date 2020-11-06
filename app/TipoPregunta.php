<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_pregunta';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
