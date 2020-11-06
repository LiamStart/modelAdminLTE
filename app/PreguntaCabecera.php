<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaCabecera extends Model
{
          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preguntas_cabecera';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    public function tipo_d()
    {
        return $this->belongsTo('App\TipoPregunta','tipo','id');
    }
}
