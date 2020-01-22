<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Cart;
use App\Category;
use App\Product;
use App\Order;
use App\Slider;
use App\Page;
use App\Setting;
use App\Wishlist;
use App\Productreview;

use Session;
use Auth, Artisan;
use Response;
use Carbon\Carbon;
use Mail;

class ProductController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function getIndex() {
      
      // $products = Product::where('isAvailable', '!=', '0')
      //                    ->orderBy('id', 'desc')
      //                    ->paginate(10);
      $sliders = Slider::orderBy('id', 'asc')->get();

      return view('shop.index')
                  ->withSliders($sliders);
    }

    public function getIndexAdhoc() {
      
      return redirect()->route('product.index');
    }

    public function getAbout() 
    {
      $recentproducts = Product::orderBy('id', 'desc')->get()->take(10);
      return view('shop.about')->withRecentproducts($recentproducts);
    }

    public function getContact() 
    {
      return view('shop.contact');
    }

    public function postContactMessage(Request $request) 
    {
      $this->validate($request, [
        'name'                 => 'required',
        'phone'                => 'sometimes',
        'email'                => 'required',
        'message'                => 'required',
        'contact_sum_result'   => 'required'
      ]);

      if($request->contact_sum_result_hidden == $request->contact_sum_result) {
         try{
           // EMAIL
           $data = array(
               'email' => 'loyalovijatri@gmail.com',
               'name' => $request->name,
               'from' => $request->email,
               'phone' => $request->phone,
               'message_data' => $request->message,
               'subject' => 'Message from LOYAL অভিযাত্রী Contact Form',
           );
           Mail::send('emails.contact', $data, function($message) use ($data){
             $message->from($data['from'], 'LOYAL অভিযাত্রী Contact');
             $message->to($data['email']);
             $message->subject($data['subject']);
           });
           // EMAIL
           Session::flash('success', 'We received your message, thank you!');
           return redirect()->route('index.contact');
         } catch(\Exception $e) {
           Session::flash('warning', 'We cannot process your message right now, sorry!');
           return redirect()->route('index.contact');
         }
      } else {
          return redirect()->route('index.contact')->with('warning', 'Please write the sum result correctly!')->withInput();
      }
    }

    public function getPrivacy() 
    {
      return view('shop.privacy');
    }

    public function getTerms() 
    {
      return view('shop.terms');
    }

    public function getSingleProduct($id, $random_string) 
    {
      $product = Product::findOrFail($id);
      $relatedproducts = Product::where('isAvailable', '!=', '0')
                         ->where('category_id', $product->category_id)
                         ->inRandomOrder()
                         ->get()->take(10);
      $newarrivals = Product::orderBy('id', 'desc')->where('isAvailable', 1)->get()->take(5);

      return view('shop.singleproduct')
                        ->withProduct($product)
                        ->withRelatedproducts($relatedproducts)
                        ->withNewarrivals($newarrivals);
    }

    public function storeProductReview(Request $request) 
    {
      // check if already reviewd
      $reviewcheck = Productreview::where('product_id', $request->product_id)
                                  ->where('user_id', Auth::user()->id)
                                  ->first();
      if(!empty($reviewcheck)) {
        Session::flash('info', 'You have reviewed this product once. Thank you.');
        return redirect()->route('product.getsingleproduct', [$request->product_id, generate_token(100)]);
      }

      $this->validate($request, [
        'product_id'           => 'required',
        'rating'               => 'sometimes',
        'comment'              => 'required'
      ]);

      $review = new Productreview;
      $review->rating = $request->rating;
      $review->comment = $request->comment;
      $review->product_id = $request->product_id;
      $review->user_id = Auth::user()->id;
      $review->save();

      Session::flash('success', 'Thank you for your review!');
      return redirect()->route('product.getsingleproduct', [$request->product_id, generate_token(100)]);
    }

    public function addProductToWishList($product_id, $user_id) 
    {
      $checkwishlist = Wishlist::where('product_id', $product_id)
                               ->where('user_id', $user_id)
                               ->first();

      if(!empty($checkwishlist)) {
        Session::flash('info', 'This product is already in your WishList! Thanks you.');
        return redirect()->route('product.getsingleproduct', [$product_id, generate_token(100)]);
      } else {
        $wishlist = new Wishlist;
        $wishlist->product_id = $product_id;
        $wishlist->user_id = $user_id;
        $wishlist->save();

        Session::flash('success', 'This product is added to your WishList! Thanks you.');
        return redirect()->route('product.getsingleproduct', [$product_id, generate_token(100)]);
      }
    }

    public function getCategoryWise($id, $random_string) {
      $products = Product::where('isAvailable', '!=', '0')
                         ->where('category_id', $id)
                         ->paginate(10);
      $newarrivals = Product::orderBy('id', 'desc')->where('isAvailable', 1)->get()->take(5);
      return view('shop.categorywise')
                ->withProducts($products)
                ->withNewarrivals($newarrivals)
                ->withCatorsubid($id);
    }

    public function getSubcategoryWise($id, $random_string) {
      $products = Product::where('isAvailable', '!=', '0')
                         ->where('subcategory_id', $id)
                         ->paginate(10);
      $newarrivals = Product::orderBy('id', 'desc')->where('isAvailable', 1)->get()->take(5);
      return view('shop.categorywise')
                  ->withProducts($products)
                  ->withNewarrivals($newarrivals)
                  ->withCatorsubid($id)
                  ->withSubcategoryid($id); // for active class
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

    public function getAddToCartSingle(Request $request, $id, $qty) {
      // this method returns an API response
      $product = Product::find($id);
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->add($product, $product->id);

      $request->session()->put('cart', $cart);
      
      // if qty > 1 then...
      if($qty > 1) {
        for ($i=1; $i < $qty; $i++) { 
          $this->getAddByOne($id);
        }
      }

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

      $this->validate($request, [
        'address'              => 'required',
        'fcode'                => 'sometimes',
        'useearnedbalance'     => 'required',
        'deliverylocation'     => 'required',
        'payment_method'       => 'required'
      ]);

      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);

      // calculate deliverycharge
      if($request->deliverylocation == 0) {
        $cart->addDeliveryCharges(60); // hardcoder deliverycharge
      } elseif($request->deliverylocation == 1020) {
        // do nothing
      } else {
        $cart->addDeliveryCharges(100); // hardcoder deliverycharge
      }

      // calculate with the earned balance
      if((($cart->totalPrice > Auth::user()->points) && ($request->useearnedbalance <= Auth::user()->points)) || ((Auth::user()->points > $cart->totalPrice) && ($request->useearnedbalance <= $cart->totalPrice)))
      {
        $cart->calculateEarnedBalance((float) $request->useearnedbalance);
        Auth::user()->points = Auth::user()->points - $request->useearnedbalance;
        Auth::user()->save();
      }
      
      // dd($cart->totalPrice);
      try{
        $order = new Order();
        $order->cart = serialize($cart); // save korar somoy serialize kore save korte hobe
        $order->totalprice = $cart->totalPrice;
        $order->totalprofit = $cart->totalProfit;
        $order->address = $request->address;
        $order->status = 0; // 0 means pending
        $order->paymentstatus = 'not-paid';
        $order->payment_method = $request->payment_method; // 0 means cash on delivery, 1 means bKash
        $order->deliverylocation = $request->deliverylocation; // 0 == Dhaka, 1020 = free pickup, 2 = outside of Dhaka
        $nowdatetime = Carbon::now();

        $order->payment_id = $nowdatetime->format('YmdHis') . random_string(5);
        Auth::user()->orders()->save($order);

        if($request->fcode && $request->fcode != Auth::user()->code) {
          $friend = User::where('code', $request->fcode)->first();
          if(!empty($friend)) {
            $setting = Setting::findOrFail(1);
            $friend->points = $friend->points + ($order->totalprofit * ($setting->give_away_percentage / 100)); // ei 2% change hobe, dynamically
            $friend->save();

            $friendspoint = $order->totalprofit * ($setting->give_away_percentage / 100);
            Session::flash('info', 'আপনার এ অর্ডারটি থেকে আপনার বন্ধু ' . $friend->name . '-এর একাউন্টে মোট ' . $friendspoint . ' পয়েন্ট যোগ হয়েছে!');
          } else {
            Session::flash('warning', 'আপনার বন্ধুর ইউজার আইডিটি সঠিক নয়! ধন্যবাদ।');
          }  
        } elseif($request->fcode == Auth::user()->code){
          Session::flash('warning', 'আপনি নিজের আইডিকে রেফার করতে পারবেন না! ধন্যবাদ।');
        }
      } catch(\Exception $e) {
        Session::flash('warning', 'আপনার নিশ্চিতকরণে কোন সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        return redirect()->route('product.index');
      }

      try{
        // EMAIL
        $order->cart = unserialize($order->cart);
        $data = array(
            'email' => Auth::user()->email,
            'from' => 'support@loyalovijatri.com',
            'subject' => 'Your LOYAL অভিযাত্রী Invoice',
            'order' => $order,
        );
        Mail::send('emails.receipt', $data, function($message) use ($data){
            $message->from($data['from'], 'LOYAL অভিযাত্রী Invoice');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });
        // EMAIL
        Session::flash('success', 'We sent the invoice to your email!');
      } catch(\Exception $e) {
        // nothing
      }

      Session::forget('cart');
      if($request->payment_method == 1) {
        Session::flash('success', 'আপনার পেমেন্ট মেথড বিকাশ, আমাদের একজন প্রতিনিধি আপনাকে ফোন করে বিকাশ নম্বর প্রদান করবেন।');
      }
      Session::flash('success', 'আপনার অর্ডারটি নিশ্চিত করা হয়েছে। শীঘ্রই আমাদের একজন প্রতিনিধি আপনার সাথে যোগাযোগ করবেন। ধন্যবাদ।');
      return redirect()->route('user.profile', Auth::user()->unique_key);
    }

    public function testMail($payment_id) 
    {
      $order = Order::where('payment_id', $payment_id)->first();
      $order->cart = unserialize($order->cart);
      $data = array(
          'email' => Auth::user()->email,
          'from' => 'support@loyalovijatri.com',
          'subject' => 'Your LOYAL অভিযাত্রী Invoice',
          'order' => $order,
      );
      Mail::send('emails.receipt', $data, function($message) use ($data){
          $message->from($data['from'], 'LOYAL অভিযাত্রী Invoice');
          $message->to($data['email']);
          $message->subject($data['subject']);
      });
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
                  <p class='text-muted'>".$product->description."</p>
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

    public function getSinglePage($slug)
    {
      $article = Page::where('slug', $slug)->first();
      if(!$article) {
        Session::flash('warning', 'এই পাতাটি এ মুহূর্তে অপ্রাপ্য!');
        return abort(404);
      } 
      $recentproducts = Product::orderBy('id', 'desc')->get()->take(10);
      $newarrivals = Product::orderBy('id', 'desc')->where('isAvailable', 1)->get()->take(5);
      return view('shop.article')
                    ->withArticle($article)
                    ->withRecentproducts($recentproducts)
                    ->withNewarrivals($newarrivals);
    }  

    public function generateSiteMap()
    {
      
    }

    public function clearSession(Request $request)
    {
      $request->session()->flush();
      Session::flash('success', 'Cart has been cleared!');
      return redirect('/');
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        // Artisan::call('route:cache');
        Artisan::call('config:cache');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
