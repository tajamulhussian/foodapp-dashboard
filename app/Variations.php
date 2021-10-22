<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variations extends Model
{
 
    protected $table = "variations";
    public $fillable = ['name','price','product_id'];

}
