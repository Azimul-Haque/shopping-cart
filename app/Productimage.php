<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{
    public function product() {
      return $this->belongsTo('App\Product');
    }
}
