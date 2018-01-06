<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
{
    public function getIndex() {
      return view('shop.index');
    }

    public function getAddProduct() {
      echo "It works";
    }
}
