<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Session;

class UserController extends Controller
{
    public function getRegister() {
      return view('user.register');
    }

    public function postRegister(Request $request) {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'email|required|unique:users',
        'phone' => 'required|unique:users',
        'password' => 'required|min:6'
      ]);

      $user = new User([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'role' => 'customer',
        'password' => bcrypt($request->input('password'))
      ]);

      $user->save();

      Auth::login($user);
      Session::flash('success', 'The account is created successfully!'); 
      return redirect()->route('product.index');
    }

    public function getLogin() {
      return view('user.login');
    }

    public function postLogin(Request $request) {
      $this->validate($request, [
        'email' => 'email|required',
        'password' => 'required|min:6'
      ]);

      if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
        Session::flash('success', 'Logged in successfully!');
        return redirect()->route('user.profile');
      }

      Session::flash('warning', 'Wrong Credentials!'); 
      return redirect()->back();
    }

    public function getProfile() {
      return view('user.profile');
    }

    public function getLogout() {
      Auth::logout();
      Session::flash('success', 'Logged out successfully!'); 
      return redirect()->route('product.index');
    }
}
