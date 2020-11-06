<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{

   protected $table = 'empleado';
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
