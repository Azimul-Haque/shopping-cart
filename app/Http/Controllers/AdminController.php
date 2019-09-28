<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Slider;
use App\Page;
use App\Setting;

use Carbon\Carbon;
use Image;
use Validator, Input, Redirect, File;
use Session;
use Auth;
use View;
use Purifier;

class AdminController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function getSettings()
    {  
      $sliders = Slider::all();
      $setting = Setting::findOrFail(1);
      return view('admin.settings')
                  ->withSliders($sliders)
                  ->withSetting($setting);
    }

    public function getCreateSlider()
    {
      return view('admin.createslider');
    }

    public function storeSlider(Request $request)
    {
      $this->validate($request, [
          'image'         => 'required|image|max:500',
          'title'         => 'sometimes|max:255',
          'button'        => 'sometimes|max:255',
          'url'           => 'sometimes|max:255',
      ]);

      $slider = new Slider;
      if($request->hasFile('image')) {
          $image      = $request->file('image');
          $filename   = 'slider_' . time() .'.' . $image->getClientOriginalExtension();
          $location   = public_path('images/slider/'. $filename);
          Image::make($image)->resize(1360, 500)->save($location);
          $slider->image = $filename;
      }
      if($request->title) {
        $slider->title = $request->title;
      }
      if($request->button) {
        $slider->button = $request->button;
      }
      if($request->url) {
        $slider->url = $request->url;
      }
      $slider->save();


      Session::flash('success', 'Added successfully!');
      return redirect()->route('admin.settings');
    }

    public function getEditSlider($id)
    {
    	$slider = Slider::findOrFail($id);
      	return view('admin.editslider')->withSlider($slider);
    }

    public function updateSlider(Request $request, $id)
    {
        $this->validate($request, [
            'image'         => 'sometimes|image|max:500',
            'title'         => 'sometimes|max:255',
            'button'        => 'sometimes|max:255',
            'url'           => 'sometimes|max:255',
        ]);

        $slider = Slider::findOrFail($id);
        if($request->hasFile('image')) {
          // delete the previous ones
          $image_path = public_path('images/slider/'. $slider->image);
          if(File::exists($image_path)) {
              File::delete($image_path);
          }
            $image      = $request->file('image');
            $filename   = 'slider_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('images/slider/'. $filename);
            Image::make($image)->resize(1360, 500)->save($location);
            $slider->image = $filename;
        }
        $slider->title = $request->title;
        $slider->button = $request->button;
        $slider->url = $request->url;
        $slider->save();


        Session::flash('success', 'Updated successfully!');
        return redirect()->route('admin.settings');
    }

    public function updateSetting(Request $request, $id)
    {
      	$this->validate($request, [
            'give_away_percentage'       => 'required|numeric',
      	    'checkconfirm'               => 'required'
      	]);

      	$setting = Setting::findOrFail($id);
      	$setting->give_away_percentage = $request->give_away_percentage;
      	$setting->save();

      	Session::flash('success', 'Updated successfully!');
      	return redirect()->route('admin.settings');
    }

    public function deleteSlider($id)
    {
    	$slider = Slider::findOrFail($id);
    	// delete the previous ones
    	$image_path = public_path('images/slider/'. $slider->image);
    	if(File::exists($image_path)) {
    	    File::delete($image_path);
    	}
    	$slider->delete();

    	Session::flash('success', 'Deleted successfully!');
      	return redirect()->route('admin.settings');
    }

    public function getPages()
    {  
      $pages = Page::all();
      return view('admin.pages')->withPages($pages);
    }

    public function getCreatePage()
    {
      return view('admin.createpage');
    }

    public function storePage(Request $request)
    {
      $this->validate($request, [
          'title'           => 'required|max:255',
          'image'           => 'required|image|max:500',
          'description'     => 'required',
          'slug'            => 'required|unique:pages',
      ]);

      $page = new Page;
      $page->title = $request->title;

      if($request->hasFile('image')) {
          $image      = $request->file('image');
          $filename   = 'page_' . time() .'.' . $image->getClientOriginalExtension();
          $location   = public_path('images/pages/'. $filename);
          Image::make($image)->resize(1200, 680)->save($location);
          $page->image = $filename;
      }
      
      $page->description = Purifier::clean($request->description, 'youtube');
      $page->slug = htmlspecialchars(preg_replace("/\s+/", " ", $request->slug.'_'.random_string(5)));
      $page->save();


      Session::flash('success', 'Added successfully!');
      return redirect()->route('admin.pages');
    }

    public function getEditPage($id)
    {
      $page = Page::findOrFail($id);
        return view('admin.editpage')->withPage($page);
    }

    public function updatePage(Request $request, $id)
    {
      $this->validate($request, [
          'title'           => 'required|max:255',
          'image'           => 'sometimes|image|max:500',
          'description'     => 'required',
          'slug'            => 'required|max:255',
      ]);

      $page = Page::findOrFail($id);
      $page->title = $request->title;

      if($request->hasFile('image')) {
      	  // delete the previous ones
      	  $image_path = public_path('images/pages/'. $page->image);
      	  if(File::exists($image_path)) {
      	      File::delete($image_path);
      	  }
          $image      = $request->file('image');
          $filename   = 'page_' . time() .'.' . $image->getClientOriginalExtension();
          $location   = public_path('images/pages/'. $filename);
          Image::make($image)->resize(1200, 680)->save($location);
          $page->image = $filename;
      }
      
      $page->description = Purifier::clean($request->description, 'youtube');
      if($page->slug != $request->slug) {
      	$page->slug = htmlspecialchars(preg_replace("/\s+/", " ", $request->slug.'_'.random_string(5)));
      }
      $page->save();

      Session::flash('success', 'Updated successfully!');
      return redirect()->route('admin.pages');
    }

    public function deletePage($id)
    {
    	$page = Page::findOrFail($id);
    	// delete the previous ones
    	$image_path = public_path('images/pages/'. $page->image);
    	if(File::exists($image_path)) {
    	    File::delete($image_path);
    	}
    	$page->delete();

    	Session::flash('success', 'Deleted successfully!');
      	return redirect()->route('admin.pages');
    }

    public function getAdmins()
    {  
      $admins = User::where('role', 'admin')->get();
      return view('admin.admins')->withAdmins($admins);
    }

    public function getCreateAdmin()
    {  
      return view('admin.createadmin');
    }

    public function storeAdmin(Request $request)
    {
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
        'address' => 'N/A',
        'role' => 'admin',
        'code' => date('Y').date('m').random_string(5),
        'unique_key' => generate_token(100),
        'password' => bcrypt($request->input('password'))
      ]);

      $user->save();

      Session::flash('success', 'Added successfully!');
      return redirect()->route('admin.admins');
    }

    public function editAdmin($id)
    {
      $admin = User::findOrFail($id);
        return view('admin.editadmin')->withAdmin($admin);
    }

    public function updateAdmin(Request $request, $id)
    {
      $this->validate($request, [
          'name'       => 'required|max:255',
          'password'   => 'required|min:6'
      ]);

      $user = User::findOrFail($id);
      $user->name = $request->name;
      $user->password = bcrypt($request->input('password'));
      $user->save();

      Session::flash('success', 'Updated successfully!');
      return redirect()->route('admin.admins');
    }

    public function deleteAdmin($id)
    {
      $user = User::findOrFail($id);

      if($user->orders->count() > 0) {
        Session::flash('warning', 'This user has purchasing history in this system, the user cannot be deleted!');
        return redirect()->route('admin.admins');
      } else {
        $user->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->route('admin.admins');
      }
    }
}
