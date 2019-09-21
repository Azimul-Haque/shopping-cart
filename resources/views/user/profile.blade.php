@extends('layouts.index')

@section('title', 'প্রোফাইল | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>প্রোফাইল</h1>
@stop

@section('content')
  <!-- head section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                  <!-- page title -->
                  <h1 class="black-text">প্রোফাইলঃ {{ Auth::user()->name }}</h1>
                  <!-- end page title -->
              </div>
              <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                  <!-- breadcrumb -->
                  <ul>
                      <li><a href="#">Home</a></li>
                      <li>Profile</li>
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
          <div class="col-md-3">
            @if(Auth::check() && Auth::user()->role == 'admin')
              {{-- @include('partials/shop-sidebar')<br/> --}}
            @endif
            
            @include('partials/_profile')
          </div>
          <div class="col-md-5">
            @if($orders->first())
            <div class="panel panel-success">
              <div class="panel-heading">
                <h4 class="panel-title">
                  @if($orders->first()->paymentstatus == 'paid')
                    <i class="fa fa-check" title="Delivered"></i>
                  @elseif($orders->first()->paymentstatus == 'not-paid')
                    <i class="fa fa-hourglass-start" title="Yet to deliver"></i>
                  @endif
                  আপনার সর্বশেষ অর্ডারঃ তারিখ ও সময়-{{ $orders->first()->created_at->format('M d, Y, h:i A') }}
                </h4>
              </div>
              <div class="panel-body">
                <h4>অর্ডার আইডিঃ {{ $orders->first()->payment_id }}</h4>
                <ul class="list-group">
                  @foreach($orders->first()->cart->items as $item)
                    <li class="list-group-item">
                      {{ $item['item']['title'] }} | {{ $item['qty'] }}
                      <span class="badge">৳ {{ $item['price'] }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
              <div class="panel-footer panel-footer-custom">
                <strong>মোট মূল্যঃ ৳ {{ $orders->first()->cart->totalPrice }}</strong>
              </div>
            </div>
            @else
            <center>
              <h2>
                কোন অর্ডার নেই!<br/>
                <a class="highlight-button btn btn-medium checkout-btn xs-width-100 xs-text-center" href="{{ route('product.index') }}"><i class="fa fa-cart-plus"></i> পণ্য দেখুন</a>
              </h2>
            </center>
            @endif
          </div>
          <div class="col-md-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">আপনার অর্ডারগুলো</h4>
              </div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                @foreach($orders as $order)
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $order->id }}">
                          @if($order->paymentstatus == 'paid')
                            <i class="fa fa-check" title="Delivered"></i>
                          @elseif($order->paymentstatus == 'not-paid')
                            <i class="fa fa-hourglass-start" title="Yet to deliver"></i>
                          @endif
                          {{ $order->created_at->format('M d, Y, h:i A') }}
                        </a>
                      </h4>
                    </div>
                    <div id="collapse{{ $order->id }}" class="panel-collapse collapse">
                      <div class="panel-body">
                        <h4>অর্ডার আইডিঃ {{ $order->payment_id }}</h4>
                        <ul class="list-group">
                          @foreach($order->cart->items as $item)
                            <li class="list-group-item">
                              {{ $item['item']['title'] }} | {{ $item['qty'] }}
                              <span class="badge">৳ {{ $item['price'] }}</span>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                      <div class="panel-footer panel-footer-custom">
                        <strong>মোট মূল্যঃ ৳ {{ $order->cart->totalPrice }}</strong>
                      </div>
                    </div>
                  </div><br/>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
  
@endsection
