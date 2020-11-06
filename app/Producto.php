<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
            /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producto';
    protected $keyType = 'string';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    public function tipos()
    {
        return $this->belongsTo('App\TipoProducto', 'id_tipo');
    }
}
