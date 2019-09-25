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
              @foreach($cart->items as $item)
              <li class="list-group-item">
                {{-- {{ json_encode($item) }} --}}
                {{ $item['item']['title'] }} | {{ $item['qty'] }}
                <span class="right">৳ {{ $item['price'] }}</span>
              </li>
              @endforeach
            </ul>
            
            <ul class="list-group">
              <li class="list-group-item">
                <h4 class="right">ডেলিভারি চার্জঃ ৳ <span id="deliveryCharge">{{ $cart->deliveryCharge }}</span></h4><br/>
              </li>
              <li class="list-group-item">
                <h4 class="right bold">মোট পরিশোধনীয় মূল্যঃ ৳ <span id="totalPrice">{{ $cart->totalPrice }}</span></h4><br/>
              </li>
            </ul>
            
            
            {!! Form::open(['route' => 'product.checkout', 'method' => 'POST']) !!}

              {!! Form::label('address', 'পণ্য প্রেরণের ঠিকানা') !!}
              {!! Form::text('address', Auth::user()->address, array('class' => 'form-control')) !!}<br/>

              <div class="row">
                <div class="col-md-4">
                  <label for="district">District</label>
                  <select id="district" name="district" class="form-control" required="">
                    <option value="" selected="" disabled="">Select District</option>
                    <option value="DHAKA">DHAKA</option>
                    <option value="THAKURGAON">THAKURGAON</option>
                    <option value="RANGPUR">RANGPUR</option>
                    <option value="DINAJPUR">DINAJPUR</option>
                    <option value="GAIBANDHA">GAIBANDHA</option>
                    <option value="KURIGRAM">KURIGRAM</option>
                    <option value="NILPHAMARI">NILPHAMARI</option>
                    <option value="PANCHAGARH">PANCHAGARH</option>
                    <option value="LALMONIRHAT">LALMONIRHAT</option>
                    <option value="KUSHTIA">KUSHTIA</option>
                    <option value="KHULNA">KHULNA</option>
                    <option value="CHUADANGA">CHUADANGA</option>
                    <option value="JHENAIDAH">JHENAIDAH</option>
                    <option value="NARAIL">NARAIL</option>
                    <option value="BAGERHAT">BAGERHAT</option>
                    <option value="MAGURA">MAGURA</option>
                    <option value="MEHERPUR">MEHERPUR</option>
                    <option value="JASHORE">JASHORE</option>
                    <option value="SATKHIRA">SATKHIRA</option>
                    <option value="CHATTOGRAM">CHATTOGRAM</option>
                    <option value="COX'S BAZAR">COX'S BAZAR</option>
                    <option value="BANDARBAN">BANDARBAN</option>
                    <option value="KHAGRACHARI">KHAGRACHARI</option>
                    <option value="RANGAMATI">RANGAMATI</option>
                    <option value="NOAKHALI">NOAKHALI</option>
                    <option value="LAKSHMIPUR">LAKSHMIPUR</option>
                    <option value="FENI">FENI</option>
                    <option value="CUMILLA">CUMILLA</option>
                    <option value="CHANDPUR">CHANDPUR</option>
                    <option value="BRAHMANBARIA">BRAHMANBARIA</option>
                    <option value="NARSINGDI">NARSINGDI</option>
                    <option value="NARAYANGANJ">NARAYANGANJ</option>
                    <option value="GAZIPUR">GAZIPUR</option>
                    <option value="MUNSHIGANJ">MUNSHIGANJ</option>
                    <option value="MANIKGANJ">MANIKGANJ</option>
                    <option value="TANGAIL">TANGAIL</option>
                    <option value="RAJBARI">RAJBARI</option>
                    <option value="GOPALGANJ">GOPALGANJ</option>
                    <option value="SHARIATPUR">SHARIATPUR</option>
                    <option value="MADARIPUR">MADARIPUR</option>
                    <option value="FARIDPUR">FARIDPUR</option>
                    <option value="KISHOREGANJ">KISHOREGANJ</option>
                    <option value="BARISAL">BARISAL</option>
                    <option value="BARGUNA">BARGUNA</option>
                    <option value="BHOLA">BHOLA</option>
                    <option value="JHALAKATHI">JHALAKATHI</option>
                    <option value="PATUAKHALI">PATUAKHALI</option>
                    <option value="PIROJPUR">PIROJPUR</option>
                    <option value="MYMENSINGH">MYMENSINGH</option>
                    <option value="SHERPUR">SHERPUR</option>
                    <option value="JAMALPUR">JAMALPUR</option>
                    <option value="NETROKONA">NETROKONA</option>
                    <option value="RAJSHAHI">RAJSHAHI</option>
                    <option value="NATORE">NATORE</option>
                    <option value="CHAPAINAWABGANJ">CHAPAINAWABGANJ</option>
                    <option value="JOYPURHAT">JOYPURHAT</option>
                    <option value="NAOGAON">NAOGAON</option>
                    <option value="BOGURA">BOGURA</option>
                    <option value="PABNA">PABNA</option>
                    <option value="SIRAJGANJ">SIRAJGANJ</option>
                    <option value="MOULVIBAZAR">MOULVIBAZAR</option>
                    <option value="SYLHET">SYLHET</option>
                    <option value="SUNAMGANJ">SUNAMGANJ</option>
                    <option value="HABIGANJ">HABIGANJ</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="payment_method">Payment Method</label>
                  <select id="payment_method" name="payment_method" class="form-control" required="">
                    <option value="" disabled="">Payment Method</option>
                    <option value="0" selected="">Cash On Delivery</option> {{-- apatoto --}}
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="fcode">আপনার বন্ধুর ইউজার আইডি (যদি থাকে) <a href="#!" title="আপনার বন্ধুর ইউজার আইডি দিলে তার একাউন্টে পয়েন্ট যোগ হবে!"><i class="fa fa-question-circle"></i></a></label>
                  {!! Form::text('fcode', null, array('class' => 'form-control')) !!}
                </div>
              </div>

              {!! Form::submit('আপনার অর্ডারটি নিশ্চিত করুন', array('class' => 'highlight-button-black-background btn btn-medium  no-margin pull-right checkout-btn xs-width-100 xs-text-center', 'style' => 'margin-top:20px;')) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
  <script type="text/javascript">
    $('#district').change(function() {
      var deliveryCharge;
      var oldTotalPrice;
      if($('#district').val() == 'DHAKA') {
        deliveryCharge = 60;
      } else {
        deliveryCharge = 100;
      }
      $('#deliveryCharge').text(deliveryCharge);
      $('#totalPrice').text({{ $cart->totalPrice }} + deliveryCharge);
    })
  </script>
@endsection