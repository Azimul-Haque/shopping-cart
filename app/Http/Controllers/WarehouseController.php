<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Product;
use App\Order;
use Carbon\Carbon;
use Image;
use Validator, Input, Redirect;
use Session;
use Auth;
use View;

class WarehouseController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    
    public function getDashboard() {
      return view('warehouse.dashboard');
    }

    public function getCategories() {
      $categories = Category::all();
      return view('warehouse.categories')->withCategories($categories);
    }

    public function postCategories(Request $request) {
      $this->validate($request, [
        'name'=>'required|max:255|unique:categories,name'
      ]);

      $category = new Category;
      $category->name = $request->input('name');
      $category->save();

      Session::flash('success', 'Category is added successfully!');
      return redirect()->route('warehouse.categories');
    }

    public function getAddProduct() {
      $products = Product::all();
      $categories = Category::all();
      return view('warehouse.addproduct')
                  ->withProducts($products)
                  ->withCategories($categories);
    }

    public function postAddProduct(Request $request) {
      $this->validate($request, [
          'title' => 'required|max:255',
          'description' => 'sometimes|max:255',
          'oldprice' => 'sometimes|numeric',
          'price' => 'required|numeric',
          'category_id' => 'required',
          'image' => 'sometimes|image|max:200'
      ]);

      $product = new Product;
      $product->title = $request->title;
      $product->description = $request->description;
      $product->oldprice = $request->oldprice;
      $product->price = $request->price;
      $product->category_id = $request->category_id;
      $product->isAvailable = 1;
      
      // image upload
      if($request->hasFile('image')) {
          $image      = $request->file('image');
          $nowdatetime = Carbon::now();
          $filename   = str_replace(' ','',$product->title).$nowdatetime->format('YmdHis') .'.' . $image->getClientOriginalExtension();
          $location   = public_path('images/product-images/'. $filename);

          Image::make($image)->resize(200, 200)->save($location);
          /*Image::make($image)->resize(300, 300, function ($constraint) {
          $constraint->aspectRatio();
          })->save($location);*/

          $product->imagepath = $filename;
      }

      $product->save();

      Session::flash('success', 'Product is added successfully!');
      return redirect()->route('warehouse.addproduct');
    }

    public function getEditProduct($id) {
      $product = Product::find($id);
      $products = Product::all();
      $categories = Category::all();
      return view('warehouse.addproduct')
                  ->withProduct($product)
                  ->withProducts($products)
                  ->withCategories($categories);
    }

    public function putEditProduct(Request $request, $id) {
      $this->validate($request, [
          'title' => 'required|max:255',
          'description' => 'sometimes|max:255',
          'oldprice' => 'sometimes|numeric',
          'price' => 'required|numeric',
          'category_id' => 'required',
          'image' => 'sometimes|image|max:200'
      ]);

      $product = Product::find($id);;
      $product->title = $request->title;
      $product->description = $request->description;
      $product->oldprice = $request->oldprice;
      $product->price = $request->price;
      $product->category_id = $request->category_id;
      
      // image upload
      if($request->hasFile('image')) {
          // delete previous image
          \File::delete([
            public_path('images/product-images/'. $product->imagepath)
          ]);
          $image      = $request->file('image');
          $nowdatetime = Carbon::now();
          $filename   = str_replace(' ','',$product->title).$nowdatetime->format('YmdHis') .'.' . $image->getClientOriginalExtension();
          $location   = public_path('images/product-images/'. $filename);

          Image::make($image)->resize(200, 200)->save($location);
          /*Image::make($image)->resize(300, 300, function ($constraint) {
          $constraint->aspectRatio();
          })->save($location);*/

          $product->imagepath = $filename;
      }

      $product->save();

      Session::flash('success', 'Product is updated successfully!');
      return redirect()->route('warehouse.addproduct');
    }

    public function putUnavailableProduct(Request $request, $id) {
      $product = Product::find($id);
      if($product->isAvailable == 1) {
        $product->isAvailable = 0;
      } elseif($product->isAvailable == 0) {
        $product->isAvailable = 1;
      }
      
      $product->save();

      if($product->isAvailable == 1) {
        Session::flash('success', 'পণ্যটি সফলভাবে প্রাপ্য করা হয়েছে। এটি এখন পণ্য তালিকায় দেখা যাবে!');
      } elseif($product->isAvailable == 0) {
        Session::flash('success', 'পণ্যটি সফলভাবে অপ্রাপ্য করা হয়েছে। এটি আর পণ্য তালিকায় দেখা যাবে ন।!');
      }
      
      return redirect()->route('warehouse.addproduct');
    }

    public function getDueOrdersApi() {
      $due_orders = '';
      if(Auth::check() && Auth::user()->role == 'admin') {
        $due_orders = Order::where('paymentstatus', '=', 'not-paid')->count();
      } 
      else {
        $due_orders = collect(new Order);
      }

      echo $due_orders;
    }

    public function getDueOrders() {
      $dueorders = Order::where('paymentstatus', '=', 'not-paid')
                          ->orderBy('id', 'desc')
                          ->get();
      $dueorders->transform(function($order, $key) {
        $order->cart = unserialize($order->cart);
        return $order;
      });
      $orderstoday = Order::where('created_at', '>=', Carbon::today())
                            ->orderBy('id', 'desc')
                            ->get();
      $orderstoday->transform(function($order, $key) {
        $order->cart = unserialize($order->cart);
        return $order;
      });
      return view('warehouse.dueorders')
              ->withDueorders($dueorders)
              ->withOrderstoday($orderstoday);
    }

    public function putConfirmOrder(Request $request, $id) {
      $order = Order::find($id);
      $order->paymentstatus = 'paid';
      $order->save();

      Session::flash('success', 'অর্ডারটি কনফার্ম করা হয়েছে!');
      
      return redirect()->route('warehouse.dueorders');
    }
}
