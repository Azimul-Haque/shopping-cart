@extends('layouts.index')

@section('title', 'Profile | LOYAL অভিযাত্রী')

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
          <div class="col-md-9">
            @if($orders->first())
            <div class="panel panel-success shadow-light">
              <div class="panel-heading">
                <h4 class="panel-title">
                  @if($orders->first()->paymentstatus == 'paid')
                    <i class="fa fa-check" title="Delivered"></i>
                  @elseif($orders->first()->paymentstatus == 'not-paid')
                    <i class="fa fa-hourglass-start" title="Yet to deliver"></i>
                  @endif
                  Last Order: {{ $orders->first()->created_at->format('M d, Y, h:i A') }}
                </h4>
              </div>
              <div class="panel-body">
                <h4>
                  <a href="{{ route('warehouse.receiptpdf', [$orders->first()->payment_id, generate_token(100)]) }}" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn pull-right" title="Print Invoice" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                  Order ID: {{ $orders->first()->payment_id }}
                  <br/>
                  Payment Method: {{ payment_method($orders->first()->payment_method) }}<br/>
                </h4>
                Delivery Location:<br/>
                <span>
                  @if($orders->first()->deliverylocation == 1020)
                    {{ deliverylocation($orders->first()->deliverylocation) }}
                  @else
                    {{ $orders->first()->user->address }}
                  @endif
                </span>
                <ul class="list-group">
                  @foreach($orders->first()->cart->items as $item)
                    <li class="list-group-item">
                      <div style="float: left;">{{ $item['item']['title'] }}</div> | {{ $item['qty'] }}
                      <span class="badge">৳ {{ $item['price'] }}</span>
                    </li>
                  @endforeach
                </ul>
                <ul class="list-group">
                  <li class="list-group-item">
                    Delivery Charge
                    <span class="badge">৳ {{ json_encode($orders->first()->cart->deliveryCharge) }}</span>
                  </li>
                </ul>
              </div>
              <div class="panel-footer panel-footer-custom">
                <strong>Total Payable <span style="float: right;">৳ {{ $orders->first()->cart->totalPrice }}</span></strong>
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
            <br/>
            <div class="panel panel-primary shadow-light">
              <div class="panel-heading">
                <h4 class="panel-title">আপনার পূর্ববর্তী অর্ডারগুলো</h4>
              </div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                @foreach($orders as $order)
                  <div class="panel panel-success shadow-light">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#receiptcollapse{{ $order->id }}">
                          @if($order->paymentstatus == 'paid')
                            <i class="fa fa-check" title="Delivered"></i>
                          @elseif($order->paymentstatus == 'not-paid')
                            <i class="fa fa-hourglass-start" title="Yet to deliver"></i>
                          @endif
                          {{ $order->created_at->format('M d, Y, h:i A') }}
                        </a>
                      </h4>
                    </div>
                    <div id="receiptcollapse{{ $order->id }}" class="panel-collapse collapse">
                      <div class="panel-body">
                        <h4>
                          <a href="{{ route('warehouse.receiptpdf', [$order->payment_id, generate_token(100)]) }}" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn pull-right" title="Print Invoice" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                          Order ID: {{ $order->payment_id }}<br/>
                          Payment Method: {{ payment_method($order->payment_method) }}<br/>
                        </h4>
                        Delivery Location:<br/>
                        <span>
                          @if($order->deliverylocation == 1020)
                            {{ deliverylocation($order->deliverylocation) }}
                          @else
                            {{ $order->user->address }}
                          @endif
                        </span>
                        <ul class="list-group">
                          @foreach($order->cart->items as $item)
                            <li class="list-group-item">
                              <div style="white-space: nowrap; max-width: 150px; overflow: hidden; text-overflow: ellipsis; float: left;" title="{{ $item['item']['title'] }}">
                                {{ $item['item']['title'] }}
                              </div> | {{ $item['qty'] }}
                              <span class="badge">৳ {{ $item['price'] }}</span>
                            </li>
                          @endforeach
                        </ul><ul class="list-group">
                        <li class="list-group-item">
                          Delivery Charge
                          <span class="badge">৳ {{ json_encode($order->cart->deliveryCharge) }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="panel-footer panel-footer-custom">
                      <strong>Total Payable <span style="float: right;">৳ {{ $order->cart->totalPrice }}</span></strong>
                    </div>
                    </div>
                  </div>
                @endforeach
                <br/>
                @include('pagination.default', ['paginator' => $orders])
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            
          </div>
        </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
  
@endsection
