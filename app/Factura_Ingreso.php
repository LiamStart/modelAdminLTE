<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_Ingreso extends Model
{
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'factura_ingreso';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function cliente()
    {
        return $this->belongsTo('App\Proveedor','id_cliente');
    }
}
