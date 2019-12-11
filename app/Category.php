<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'cart';

    public function posts()
    {
        return $this->hasMany('App\Post','category_id','id');
    }
}
