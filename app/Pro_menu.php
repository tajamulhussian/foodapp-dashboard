<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pro_menu extends Model
{
    protected $table = "pro_menus";
    public $fillable = ['name','banner'];
}
