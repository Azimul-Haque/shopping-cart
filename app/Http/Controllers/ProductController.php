<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cart;
use App\Category;
use App\Product;
use App\Order;
use Session;
use Auth;
use Response;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function getIndex() {
      $products = Product::where('isAvailable', '!=', '0')->get();
      return view('shop.index')->withProducts($products);
    }

    public function getAddToCart(Request $request, $id) {
      // this method returns an API response
      $product = Product::find($id);
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->add($product, $product->id);

      $request->session()->put('cart', $cart);
      //return redirect()->route('product.index');
      return 'success';
    }

    public function getAddByOne($id) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->addByOne($id);

      Session::put('cart', $cart);
      //return redirect()->route('product.shoppingcart');
      return 'success';
    }

    public function getReduceByOne($id) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->reduceByOne($id);

      if(count($cart->items) > 0) {
        Session::put('cart', $cart);
      } else {
        Session::forget('cart');
      }
      //return redirect()->route('product.shoppingcart');
      return 'success';
    }

    public function getRemoveItem($id) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->removeItem($id);

      if(count($cart->items) > 0) {
        Session::put('cart', $cart);
      } else {
        Session::forget('cart');
      }
      return redirect()->route('product.shoppingcart');
    }

    public function getCart() {
      if(!Session::has('cart')) {
        return view('shop.shoppingcart');
      }
      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);
      return view('shop.shoppingcart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout() {
      if(!Session::has('cart')) {
        return view('shop.shoppingcart');
      }
      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);
      return view('shop.checkout', ['cart' => $cart]);
    }

    public function postCheckout(Request $request) {
      if(!Session::has('cart')) {
        return view('shop.shoppingcart');
      }
      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);

      try{
        $order = new Order();
        $order->cart = serialize($cart);
        $order->address = $request->address;
        $order->paymentstatus = 'not-paid';
        $nowdatetime = Carbon::now();
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@$&_';
        $random_string = substr(str_shuffle(str_repeat($pool, 8)), 0, 8);
        $order->payment_id = $nowdatetime->format('YmdHis').$random_string;

        Auth::user()->orders()->save($order);
      } catch(\Exception $e) {
        Session::flash('error', 'আপনার নিশ্চিতকরণে কোন সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        return redirect()->route('product.index');
      }

      Session::forget('cart');
      Session::flash('success', 'আপনার অর্ডারটি নিশ্চিত করা হয়েছে। শীঘ্রই আমাদের একজন প্রতিনিধি আম্নার সাথে যোগাযোগ করবেন। ধন্যবাদ।');
      return redirect()->route('user.profile');
    }


    public function search(Request $request) {
      if($request->ajax()) {
        $output = "";
        $products = Product::where('title', 'LIKE', '%'.$request->search.'%')
                           ->orWhere('description', 'LIKE', '%'.$request->search.'%')
                           ->orWhere('price', 'LIKE', '%'.$request->search.'%')
                           ->orWhere('imagepath', 'LIKE', '%'.$request->search.'%')
                           ->get();
        if($products) {
          foreach ($products as $key => $product) {
            $output.= "
            <div class='col-xs-6 col-sm-4 col-md-3 col-lg-2 col-lg-5ths' id=''>
              <div class='thumbnail'>
                <img src=". asset('images/product-images/'.$product->imagepath)." alt=". $product->title ." class='img-responsive product-thumbnail'>
                <div class='caption'>
                  <h4>".$product->title."</h4>
                  <p class='description'>".$product->description."</p>
                  <div class='clearfix'>
                    <div class='price'>
                      ৳ ".$product->price."
                      <small class='oldprice'>৳ <strike>".$product->oldprice."</strike></small>
                    </div>
                    <button onclick='s_addToCart(".$product->id.")' id='s_addToCart".$product->id."' class='btn btn-success btn-block btn-sm' role='button' data-title='".$product->title."'><i class='fa fa-shopping-cart' aria-hidden='true'></i> ব্যাগে যোগ করুন</button>
                  </div>
                </div>
              </div>
            </div>
            ";
          }
          return Response($output);
        }
      }
    }

    public function autocpmplete(Request $request) {
      $products = Product::all();
      if($products->count() > 0) {
        foreach ($products as $key => $product) {
          $searchResult[] = $product;
        }
      }
      return $searchResult;
    }
}
