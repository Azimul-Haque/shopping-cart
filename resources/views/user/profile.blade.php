@extends('layouts.master')

@section('title', 'প্রোফাইল | ইকমার্স')

@section('content')
  <div class="row">
    <div class="col-md-3">
      @if(Auth::check() && Auth::user()->role == 'admin')
        {{-- @include('partials/shop-sidebar')<br/> --}}
      @endif
      
      @include('partials/_profile')
    </div>
    <div class="col-md-6">
      <h1>প্রোফাইল</h1>
      @if($orders->first())
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4 class="panel-title">
            @if($orders->first()->paymentstatus == 'paid')
              <i class="fa fa-check" title="Delivered"></i>
            @elseif($orders->first()->paymentstatus == 'not-paid')
              <i class="fa fa-hourglass-start" title="Yet to deliver"></i>
            @endif
            আপনার সর্বশেষ অর্ডারঃ তারিখ ও সময়-{{ $orders->first()->created_at->format('F d, Y, h:i A') }}
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
      @endif
    </div>
    <div class="col-md-3">
      <h3>আপনার অর্ডারগুলো</h3>
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
                তারিখ ও সময়ঃ {{ $order->created_at->format('F d, Y, h:i A') }}
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
        </div>
      @endforeach
      </div>
    </div>
  </div>
@endsection