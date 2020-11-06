<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cliente';
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
