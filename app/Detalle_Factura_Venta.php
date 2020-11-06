<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Factura_Venta extends Model
{         /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'detalle_factura_venta';

   /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
   protected $guarded = [];
   public function factura()
   {
       return $this->belongsTo('App\FacturaVenta','id_factura');
   }
   public function cliente()
   {
       return $this->belongsTo('App\Cliente','id_cliente');
   }
}
