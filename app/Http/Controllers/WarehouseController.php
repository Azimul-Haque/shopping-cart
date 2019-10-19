<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Productimage;
use App\Order;
use Carbon\Carbon;
use Image;
use DB, Validator, Input, Redirect, File;
use Session;
use Auth;
use View;
use PDF;
use Purifier;

class WarehouseController extends Controller
{
    public function __construct(){
      parent::__construct();
    }
    
    public function getDashboard() {
      $orders = Order::all();
      $totalorders = $orders->count();
      $totalincome = 0;
      foreach ($orders as $order) {
        $order->cart = unserialize($order->cart); // IMPORTANT
        $totalincome = $totalincome + $order->cart->totalPrice;
      }
      $totalcustomers = User::where('role', 'customer')->count();
      $totalproducts = Product::count();

      // chart data
      $lastsevendayscollection = DB::table('orders')
                      ->select('created_at', DB::raw('SUM(totalprice) as total'))
                      ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                      ->orderBy('created_at', 'DESC')
                      ->take(7)
                      ->get();
      $datesforchartc = [];
      foreach ($lastsevendayscollection as $key => $days) {
          $datesforchartc[] = date_format(date_create($days->created_at), "M d");
      }
      $datesforchartc = json_encode(array_reverse($datesforchartc));

      $totalsforchartc = [];
      foreach ($lastsevendayscollection as $key => $days) {
          $totalsforchartc[] = $days->total;
      }
      $totalsforchartc = json_encode(array_reverse($totalsforchartc));
      // chart data

      $orderstoday = Order::where('created_at', '>=', Carbon::today())
                            ->orderBy('id', 'desc')
                            ->get();
      $orderstoday->transform(function($order, $key) {
        $order->cart = unserialize($order->cart);
        return $order;
      });

      return view('warehouse.dashboard')
                    ->withTotalorders($totalorders)
                    ->withTotalincome($totalincome)
                    ->withTotalcustomers($totalcustomers)
                    ->withTotalproducts($totalproducts)
                    ->withDatesforchartc($datesforchartc)
                    ->withTotalsforchartc($totalsforchartc)
                    ->withOrderstoday($orderstoday);
    }

    public function getCategories() {
      $categories = Category::all();
      $subcategories = Subcategory::all();
      return view('warehouse.categories')
                        ->withCategories($categories)
                        ->withSubcategories($subcategories);
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

    public function postSubcategories(Request $request) {
      $this->validate($request, [
        'name'         => 'required|max:255|unique:subcategories,name',
        'category_id'  => 'required'
      ]);

      $subcategory = new Subcategory;
      $subcategory->name = $request->name;
      $subcategory->category_id = $request->category_id;
      $subcategory->save();

      Session::flash('success', 'Subcategory is added successfully!');
      return redirect()->route('warehouse.categories');
    }

    public function getAddProduct() {
      $products = Product::orderBy('id', 'desc')->paginate(10);
      return view('warehouse.produtcs')
                  ->withProducts($products);
    }

    public function getProductSubCat($subcategory_id) {
      if($subcategory_id == 0) {
        return redirect()->route('warehouse.products');
      } else {
        $products = Product::orderBy('id', 'desc')
                           ->where('subcategory_id', $subcategory_id)
                           ->paginate(10);

        return view('warehouse.produtcs')
                    ->withProducts($products)
                    ->withSubcatselected($subcategory_id);
      }
    }

    public function searchProducts($search_param) 
    {
      $products = Product::where("title", 'LIKE', '%' . $search_param . '%')
                         ->orWhere("code", 'LIKE', '%' . $search_param . '%')
                         ->orWhere("shorttext", 'LIKE', '%' . $search_param . '%')
                         // ->orWhere("price", 'LIKE', '%' . $search_param . '%')
                         ->orderBy('id', 'desc')
                         ->paginate(10);

      return view('warehouse.produtcs')
                  ->withProducts($products)
                  ->withSearchparam($search_param);
    }

    public function postAddProduct(Request $request) {
      $this->validate($request, [
          'code'             => 'sometimes|max:255',
          'title'            => 'required|max:255|required|unique:products',
          'shorttext'        => 'required|max:255',
          'description'      => 'required',
          'oldprice'         => 'sometimes|numeric',
          'price'            => 'required|numeric',
          'stock'            => 'sometimes|numeric',
          'subcategory_id'   => 'required',

          'buying_price'     => 'required',
          'carrying_cost'    => 'required',
          'vat'              => 'required',
          'salary'           => 'required',
          'wages'            => 'required',
          'utility'          => 'required',
          'others'           => 'required',

          'image1'           => 'required|image|max:400',
          'image2'           => 'sometimes|image|max:400',
          'image3'           => 'sometimes|image|max:400',
          'image4'           => 'sometimes|image|max:400',
          'image5'           => 'sometimes|image|max:400'
      ]);

      
      $product = new Product;
      if($request->code) {
        $product->code = $request->code;
      }
      $product->imagetrackcode = random_string(6);
      $product->title = $request->title;
      $product->shorttext = $request->shorttext;
      $product->description = Purifier::clean($request->description, 'youtube');
      if($request->oldprice) {
        $product->oldprice = $request->oldprice;
      }
      $product->price = $request->price;
      if($request->stock) {
        $product->stock = $request->stock;
      }
      $product->isAvailable = 1;

      $product->subcategory_id = $request->subcategory_id;
      $findsubcat = Subcategory::findOrFail($request->subcategory_id);
      if($findsubcat) {
        $product->category_id = $findsubcat->category->id;
      }
      $product->buying_price = $request->buying_price;
      $product->carrying_cost = $request->carrying_cost;
      $product->vat = $request->vat;
      $product->salary = $request->salary;
      $product->wages = $request->wages;
      $product->utility = $request->utility;
      $product->others = $request->others;

      $total_cost = $product->buying_price + (($product->buying_price*$product->carrying_cost)/100) + (($product->buying_price*$product->vat)/100) + (($product->buying_price*$product->salary)/100) + (($product->buying_price*$product->wages)/100) + (($product->buying_price*$product->utility)/100) + (($product->buying_price*$product->others)/100);
      
      $product->profit = $product->price - $total_cost;
      $product->save();

      // upload image(s) 
      // upload image(s) 
      for($itrt=1; $itrt<=5;$itrt++) {
          if($request->hasFile('image'.$itrt)) {
              $image      = $request->file('image'.$itrt);
              $nowdatetime = Carbon::now();
              $filename   = $product->imagetrackcode. 'image'. $itrt .'.' . $image->getClientOriginalExtension();
              $location   = public_path('images/product-images/'. $filename);
              Image::make($image)->resize(600, 500)->save($location);
              $productimage = new Productimage;
              $productimage->image = $filename;
              $productimage->product_id = $product->id;
              $productimage->save();
          }
      }
      // upload image(s) 
      // upload image(s) 

      Session::flash('success', 'Product is added successfully!');
      return redirect()->route('warehouse.products');
    }

    public function getEditProduct($id, $random_string) {
      $product = Product::findOrFail($id);
      $products = Product::orderBy('id', 'desc')->paginate(10);
      $categories = Category::all();
      return view('warehouse.editproduct')
                  ->withProduct($product)
                  ->withProducts($products)
                  ->withCategories($categories);
    }

    public function putEditProduct(Request $request, $id) 
    {
       $product = Product::find($id);
       $this->validate($request, [
          'code'             => 'sometimes|max:255',
          'title'            => 'required|max:255|required|unique:products,title,' . $product->id,
          'shorttext'        => 'required|max:255',
          'description'      => 'required',
          'oldprice'         => 'sometimes|numeric',
          'price'            => 'required|numeric',
          'stock'            => 'sometimes|numeric',
          'subcategory_id'   => 'required',

          'buying_price'     => 'required',
          'carrying_cost'    => 'required',
          'vat'              => 'required',
          'salary'           => 'required',
          'wages'            => 'required',
          'utility'          => 'required',
          'others'           => 'required',

          'image1'           => 'sometimes|image|max:400',
          'image2'           => 'sometimes|image|max:400',
          'image3'           => 'sometimes|image|max:400',
          'image4'           => 'sometimes|image|max:400',
          'image5'           => 'sometimes|image|max:400'
      ]);

      if($request->code) {
        $product->code = $request->code;
      }
      $product->imagetrackcode = random_string(6);
      $product->title = $request->title;
      $product->shorttext = $request->shorttext;
      $product->description = Purifier::clean($request->description, 'youtube');
      $product->oldprice = $request->oldprice;
      $product->price = $request->price;
      if($request->stock) {
        $product->stock = $request->stock;
      }
      $product->isAvailable = 1;

      $product->subcategory_id = $request->subcategory_id;
      $findsubcat = Subcategory::findOrFail($request->subcategory_id);
      if($findsubcat) {
        $product->category_id = $findsubcat->category->id;
      }
      $product->buying_price = $request->buying_price;
      $product->carrying_cost = $request->carrying_cost;
      $product->vat = $request->vat;
      $product->salary = $request->salary;
      $product->wages = $request->wages;
      $product->utility = $request->utility;
      $product->others = $request->others;
      $total_cost = $product->buying_price + (($product->buying_price*$product->carrying_cost)/100) + (($product->buying_price*$product->vat)/100) + (($product->buying_price*$product->salary)/100) + (($product->buying_price*$product->wages)/100) + (($product->buying_price*$product->utility)/100) + (($product->buying_price*$product->others)/100);
      
      $product->profit = $product->price - $total_cost;
      
      $product->save();

      // update image(s) 
      // update image(s) 
      for($itrt=1; $itrt<=5;$itrt++) {
          if($request->hasFile('image'.$itrt)) {
              foreach ($product->productimages as $image) {
                // delete the previous ones
                $image_path = public_path('images/product-images/'. $image->image);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                    $productimage = Productimage::where('image', $image->image)->first();
                    $productimage->delete();
                }
              }
              $image      = $request->file('image'.$itrt);
              $nowdatetime = Carbon::now();
              $filename   = $product->imagetrackcode. 'image'. $itrt .'.' . $image->getClientOriginalExtension();
              $location   = public_path('images/product-images/'. $filename);
              Image::make($image)->resize(600, 500)->save($location);
              $productimage = new Productimage;
              $productimage->image = $filename;
              $productimage->product_id = $product->id;
              $productimage->save();
          }
      }
      // update image(s) 
      // update image(s)

      Session::flash('success', 'Product is updated successfully!');
      return redirect()->route('warehouse.products');
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
      
      return redirect()->route('warehouse.products');
    }

    public function getDueOrdersApi() {
      $due_orders = '';
      if(Auth::check() && Auth::user()->role == 'admin') {
        $due_orders = Order::where('status', 0)->count();
      } 
      else {
        $due_orders = collect(new Order);
      }

      echo $due_orders;
    }

    public function getDueOrders() {
      $dueorders = Order::where('status', 0) // 0 means pendings
                          ->orderBy('id', 'desc')
                          ->paginate(10);
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

    public function getInProgressOrders() {
      $inprogressorders = Order::where('status', 1) // 1 means in progress
                          ->orderBy('id', 'desc')
                          ->paginate(10);
      $inprogressorders->transform(function($order, $key) {
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
      return view('warehouse.inprogressorders')
              ->withInprogressorders($inprogressorders)
              ->withOrderstoday($orderstoday);
    }

    public function getDeliveredOrders() {
      $completedorders = Order::where('status', 2) // 2 means pendings
                          ->orderBy('id', 'desc')
                          ->paginate(10);
      $completedorders->transform(function($order, $key) {
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
      return view('warehouse.completedorders')
              ->withCompletedorders($completedorders)
              ->withOrderstoday($orderstoday);
    }

    public function getReceitPDF($payment_id, $random_string) {
      $order = Order::where('payment_id', $payment_id)->first();
      $order->cart = unserialize($order->cart);
      // dd($order->user);
      $pdf = PDF::loadView('pdf.receipt', ['order' => $order]);
      $fileName = 'Receipt_'. $payment_id .'.pdf';
      return $pdf->stream($fileName);
    }

    public function putConfirmOrder(Request $request, $id) {
      $order = Order::find($id);

      $hiddenDeliveryChargeOld = 'hiddenDeliveryChargeOld' . $id;
      $hiddenDeliveryChargeNew = 'hiddenDeliveryChargeNew' . $id;
      $deliveryAddress = 'deliveryAddress' . $id;
      $deliverylocation = 'deliverylocation' . $id;

      $order->cart = unserialize($order->cart); // kaaj korar somoy unserialize kore nite hobe
      $order->cart->totalPrice = $order->cart->totalPrice - (float) $request[$hiddenDeliveryChargeOld] + (float) $request[$hiddenDeliveryChargeNew];
      $order->totalPrice = $order->cart->totalPrice;
      $order->cart->deliveryCharge = (float) $request[$hiddenDeliveryChargeNew];

      $order->status = 1; // send to in progress
      $order->deliverylocation = $request[$deliverylocation];
      $order->address = $request[$deliveryAddress];
      $order->cart = serialize($order->cart); // save korar somoy serialize kore save korte hobe
      $order->save();

      Session::flash('success', 'অর্ডারটি কনফার্ম করা হয়েছে!');
      
      return redirect()->route('warehouse.inprogressorders');
    }

    public function putCompleteOrder(Request $request, $id) {
      $order = Order::find($id);
      $order->status = 2; // send to in complete orders
      $order->paymentstatus = 'paid';
      $order->save();

      Session::flash('success', 'অর্ডারটি সম্পূর্ণ করা হয়েছে!');
      
      return redirect()->route('warehouse.deliveredorders');
    }

    public function getCustomers() {
      $customers = User::where('role', 'customer')->paginate(10);
      return view('warehouse.customers')
              ->withCustomers($customers);
    }
}
