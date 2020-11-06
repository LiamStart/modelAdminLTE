<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{


   protected $table = 'proveedor';
   protected $keyType = 'string';
   protected $primaryKey = 'ci';
   public $incrementing = false;
   /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
   protected $guarded = [];
}
