@extends('layouts.index')

@section('title', 'ইকমার্স')

@section('css')
  <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
  <style type="text/css">
    .right {
        float: right;
    }
  </style>
@endsection

@section('content')
  <!-- head section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                  <!-- page title -->
                  <h1 class="black-text">অর্ডারটি নিশ্চিত করুন</h1>
                  <!-- end page title -->
              </div>
              <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                  <!-- breadcrumb -->
                  <ul>
                      <li><a href="#">Home</a></li>
                      <li>Checkout</li>
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
          <div class="col-md-4">
            <h2>ক্রেতার নামঃ {{ Auth::user()->name }}</h2>
            যোগাযোগের নম্বরঃ {{ Auth::user()->phone }}<br/>
            ইমেইলঃ {{ Auth::user()->email }}
          </div>
          <div class="col-md-8">
            
            <ul class="list-group">
              <li class="list-group-item"><h4 class="right">পরিশোধনীয় মূল্যঃ ৳ {{ $cart->totalPrice }}</h4><br/><br/></li>
              @if($cart->totalPrice > 300)
              <li class="list-group-item"><h4 class="right">ডেলিভারি চার্জঃ ৳ 0</h4><br/><br/></li>
              @elseif($cart->totalPrice < 300)
              <li class="list-group-item"><h4 class="right">ডেলিভারি চার্জঃ ৳ 30</h4><br/><br/></li>
              @endif

              @if($cart->totalPrice > 300)
              <li class="list-group-item"><h4 class="right bold">মোট পরিশোধনীয় মূল্যঃ ৳ {{ $cart->totalPrice + 0 }}</h4><br/><br/></li>
              @elseif($cart->totalPrice < 300)
              <li class="list-group-item"><h4 class="right bold">মোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $cart->totalPrice + 30 }}</big></h4><br/><br/></li>
              @endif
            </ul>
            
            
            {!! Form::open(['route' => 'product.checkout', 'method' => 'POST']) !!}

              {!! Form::label('address', 'পণ্য প্রেরণের ঠিকানা') !!}
              {!! Form::text('address', Auth::user()->address, array('class' => 'form-control')) !!}<br/>

              <label for="fcode">আপনার বন্ধুর ইউজার আইডি (যদি থাকে) <a href="#!" title="আপনার বন্ধুর ইউজার আইডি দিলে তার একাউন্টে পয়েন্ট যোগ হবে!"><i class="fa fa-question-circle"></i></a></label>
              {!! Form::text('fcode', null, array('class' => 'form-control')) !!}

              {!! Form::submit('আপনার অর্ডারটি নিশ্চিত করুন', array('class' => 'highlight-button-black-background btn btn-medium  no-margin pull-right checkout-btn xs-width-100 xs-text-center', 'style' => 'margin-top:20px;')) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
  
@endsection