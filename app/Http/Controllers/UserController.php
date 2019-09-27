<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Order;
use Auth;
use Session;

class UserController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    
    public function getRegister() {
      return view('user.register');
    }

    public function postRegister(Request $request) {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'email|required|unique:users',
        'phone' => 'required|unique:users',
        'address' => 'required',
        'password' => 'required|confirmed|min:6',
        'g-recaptcha-response' => 'required'
      ]);
      
      $user = new User([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'role' => 'customer',
        'code' => date('Y').date('m').random_string(5),
        'unique_key' => generate_token(100),
        'password' => bcrypt($request->input('password'))
      ]);

      $user->save();

      Auth::login($user);
      if(Session::has('oldUrl')) {
        $oldUrl = Session::get('oldUrl');
        Session::forget('oldUrl');
        return redirect()->to($oldUrl);
      }
      
      Session::flash('success', 'The account is created successfully!'); 
      return redirect()->route('product.index');
    }

    public function getLogin() {
      return view('user.login');
    }

    public function postLogin(Request $request) {
      $loginfield = 'phone';
      if (is_numeric($request->input('phoneoremail'))) {
          $loginfield = 'phone';
          $this->validate($request, [
            'phoneoremail' => 'numeric|required',
            'password' => 'required|min:6'
          ]);
      } elseif (filter_var($request->input('phoneoremail'), FILTER_VALIDATE_EMAIL)) {
          $loginfield = 'email';
          $this->validate($request, [
            'phoneoremail' => 'email|required',
            'password' => 'required|min:6'
          ]);
      }
      $this->validate($request, [
        'phoneoremail' => 'required',
        'password' => 'required|min:6'
      ]);

      if(Auth::attempt([$loginfield => $request->input('phoneoremail'), 'password' => $request->input('password')])) {
        Session::flash('success', 'Logged in successfully!');
        if(Auth::check() && Auth::user()->role == 'admin') {
          return redirect()->route('warehouse.dashboard');
        } else {
          if(Session::has('oldUrl')) {
            $oldUrl = Session::get('oldUrl');
            Session::forget('oldUrl');
            return redirect()->to($oldUrl);
          }
          return redirect()->route('user.profile', Auth::user()->unique_key);
        }
      }
      Session::flash('warning', 'তথ্য সঠিক নয়! আবার চেষ্টা করুন।'); 
      return redirect()->back();
    }

    public function getProfile($unique_key) {
      $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(5);
      $orders->transform(function($order, $key) {
        $order->cart = unserialize($order->cart);
        return $order;
      });
      return view('user.profile', ['orders' => $orders]);
    }

    public function updateProfile(Request $request, $id) 
    {
      $user = User::findOrFail($id);

      $this->validate($request, [
        'name' => 'required',
        'email' => 'email|required|unique:users,email,'.$user->id,
        'phone' => 'required|unique:users,phone,'.$user->id,
        'address' => 'required',
        'password' => 'sometimes'
      ]);

      $user->name = $request->name;
      $user->email = $request->email;
      $user->phone = $request->phone;
      $user->address = $request->address;
      if($request->password) {
        $user->password = bcrypt($request->password);
      }
      $user->save();

      Session::flash('success', 'Profile updated successfully!'); 
      return redirect()->route('user.profile', $user->unique_key);
    }

    public function getLogout() {
      Auth::logout();
      Session::flash('success', 'Logged out successfully!'); 
      return redirect()->route('product.index');
    }
}
