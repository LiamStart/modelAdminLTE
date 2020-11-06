<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'caja';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
