<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'factura_venta';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function cliente()
    {
        return $this->belongsTo('App\Cliente','id_cliente','ci');
    }
    public function detalle()
    {
        return $this->hasMany('App\Detalle_Factura_Venta','id_factura');
    }
}
