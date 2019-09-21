@extends('layouts.index')

@section('title', 'ইকমার্স | রেজিস্টার')

@section('css')

@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title page-title-small bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                    <!-- page title -->
                    <h1 class="black-text">লগইন</h1>
                    <!-- end page title -->
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                    <!-- breadcrumb -->
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li>Login</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </section>
    <!-- end head section -->

    <!-- content section -->
    <section class="content-section padding-three">
        <div class="container">
          <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="login-box">
                  <h1 style="text-align: center">রেজিস্টার করুন</h1>
                  {!! Form::open(['route' => 'user.register', 'method' => 'POST']) !!}
                    {!! Form::label('name', 'নাম') !!}
                    {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}

                    {!! Form::label('phone', 'মোবাইল নম্বর') !!}
                    {!! Form::text('phone', null, array('class' => 'form-control', 'required' => '', "onkeypress" => "if(this.value.length==11) return false;")) !!}{{-- onkeypress="if(this.value.length==11) return false;" --}}

                    {!! Form::label('email', 'ইমেইল ঠিকানা') !!}
                    {!! Form::text('email', null, array('class' => 'form-control', 'required' => '')) !!}

                    {!! Form::label('address', 'পণ্য প্রেরণের ঠিকানা') !!}
                    {!! Form::textarea('address', null, array('class' => 'form-control address', 'required' => '')) !!}

                    {!! Form::label('password', 'পাসওয়ার্ড') !!}
                    {!! Form::password('password', array('class' => 'form-control', 'required' => '')) !!}

                    {!! Form::label('password_confirmation', 'পাসওয়ার্ড নিশ্চিত করুণ') !!}
                    {!! Form::password('password_confirmation' , array('class' => 'form-control', 'required' => '')) !!}

                    {!! Form::label('captcha', 'ক্যাপচা') !!}
                    {!! app('captcha')->display() !!}

                    {!! Form::submit('রেজিস্টার', array('class' => 'highlight-button btn btn-block btn-small checkout-btn xs-width-100 xs-text-center', 'style' => 'margin-top:20px;')) !!}
                  {!! Form::close() !!}
                </div>
              </div>
          </div>
        </div>
    </section>
    <!-- end content section -->
@endsection

@section('js')
  
@endsection