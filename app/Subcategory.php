<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function products() {
      return $this->hasMany('App\Product');
    }

    public function category() {
      return $this->belongsTo('App\Category');
    }
}
