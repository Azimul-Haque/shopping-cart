@extends('layouts.index')

@section('title', 'Checkout | LOYAL অভিযাত্রী')

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
            আইডিঃ {{ Auth::user()->code }}<br/>
            যোগাযোগের নম্বরঃ {{ Auth::user()->phone }}<br/>
            ইমেইলঃ {{ Auth::user()->email }}<br/>
            <big>অর্জিত ব্যালেন্সঃ <b>৳ {{ Auth::user()->points }}</b></big>
            <br/><br/>
          </div>
          <div class="col-md-8">
            <ul class="list-group">
              @foreach($cart->items as $item)
              <li class="list-group-item">
                {{-- {{ json_encode($item) }} --}}
                {{ $item['item']['title'] }} | {{ $item['qty'] }}
                <span class="right">৳ {{ $item['price'] }}</span>
              </li>
              @endforeach
            </ul>
            {!! Form::open(['route' => 'product.checkout', 'method' => 'POST']) !!}
              <ul class="list-group">
                <li class="list-group-item">
                  <h4 class="right">ডেলিভারি চার্জঃ ৳ <span id="deliveryCharge">{{ $cart->deliveryCharge }}</span></h4><br/>
                </li>
                <li class="list-group-item">
                  <h4 class="right">
                    <table style="float: right;">
                      <tr>
                        <td><label for="useearnedbalance" style="margin-right: 10px;">অর্জিত ব্যালেন্স থেকে পরিশোধঃ ৳ </label></td>
                        <td>
                          @if($cart->totalPrice > Auth::user()->points)
                            <input type="number" name="useearnedbalance" id="useearnedbalance" max="{{ Auth::user()->points }}" min="0" class="form-control" value="0" onchange="useEarnedBalance()">
                          @else
                            <input type="number" name="useearnedbalance" id="useearnedbalance" max="{{ $cart->totalPrice }}" min="0" class="form-control" value="0" onchange="useEarnedBalance()">
                          @endif
                        </td>
                      </tr>
                    </table>
                  </h4><br/><br/>
                </li>
                <li class="list-group-item">
                  <h4 class="right bold">মোট পরিশোধনীয় মূল্যঃ ৳ <span id="totalPrice">{{ $cart->totalPrice }}</span></h4><br/>
                </li>
              </ul>

              {!! Form::label('address', 'পণ্য প্রেরণের ঠিকানা') !!}
              {!! Form::text('address', Auth::user()->address, array('class' => 'form-control')) !!}<br/>

              <div class="row">
                <div class="col-md-4">
                  <label for="deliverylocation">Delivery Location</label>
                  <select id="deliverylocation" name="deliverylocation" class="form-control" required="">
                    <option value="" selected="" disabled="">Select Location</option>
                    <option value="0">Inside Dhaka</option>
                    <option value="1020">Free Pick-up Point</option> {{-- apatoto --}}
                    <option value="2">Outside of Dhaka</option>
                  </select>
                  <span id="freePickUpPoint"></span>
                </div>
                <div class="col-md-4">
                  <label for="payment_method">Payment Method</label>
                  <select id="payment_method" name="payment_method" class="form-control" required="">
                    <option value="" selected="" disabled="">Payment Method</option>
                    <option value="0">Cash On Delivery</option>
                    <option value="1">bKash</option>
                  </select>
                  <span id="bKashText"></span>
                </div>
                <div class="col-md-4">
                  <label for="fcode">আপনার বন্ধুর ইউজার আইডি (যদি থাকে) <a href="#!" title="আপনার বন্ধুর ইউজার আইডি দিলে তার একাউন্টে পয়েন্ট যোগ হবে!"><i class="fa fa-question-circle"></i></a></label>
                  {!! Form::text('fcode', null, array('class' => 'form-control')) !!}
                </div>
              </div>

              {!! Form::submit('আপনার অর্ডারটি নিশ্চিত করুন', array('class' => 'highlight-button-black-background btn btn-medium no-margin pull-right checkout-btn xs-width-100 xs-text-center', 'style' => 'margin-top:20px;', 'id' => 'checkout-btn')) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
  <script type="text/javascript">
    $('#deliverylocation').change(function() {
      var deliveryCharge;
      var oldTotalPrice;
      if($('#deliverylocation').val() == 0) {
        deliveryCharge = 60;
        $('#freePickUpPoint').text('');
      } else if ($('#deliverylocation').val() == 1020) {
        deliveryCharge = 0;
        $('#freePickUpPoint').text('Peri Pasta or Pizza Burg, Mirpur- 02, Contact no - 01315852563');
      } else {
        deliveryCharge = 100;
        $('#freePickUpPoint').text('');
      }
      $('#deliveryCharge').text(deliveryCharge);
      $('#totalPrice').text({{ $cart->totalPrice }} + deliveryCharge);
    });

    $('#payment_method').change(function() {
      if($('#payment_method').val() == 0) {
        $('#bKashText').text('');
      } else if ($('#payment_method').val() == 1) {
        $('#bKashText').text('অর্ডার কনফার্ম করার পর আমাদের একজন প্রতিনিধি আপনাকে ফোন করে বিকাশ নম্বর প্রদান করবেন।');
      }
    })

    function useEarnedBalance() {
      // $('#checkout-btn[type="submit"]').attr('disabled','disabled');
      if({{ $cart->totalPrice }} > {{ Auth::user()->points }}) {
        toastr.warning('The amount you set cannot be more than {{ Auth::user()->points }}!').css('width', '400px');
      } else if({{ Auth::user()->points }} > {{ $cart->totalPrice }}) {
        toastr.warning('The amount you set cannot be more than {{ $cart->totalPrice }}!').css('width', '400px');
      }
      if($('#useearnedbalance').val() > {{ Auth::user()->points }}) {
        
      }
      
    }
  </script>
@endsection