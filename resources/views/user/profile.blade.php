@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-2">
      @include('partials/shop-sidebar')
    </div>
    <div class="col-md-6">
      <h1>প্রোফাইল</h1>
      @foreach($orders as $lastOrder)
        @if ($orders->first() == $lastOrder)
          <div class="panel panel-success">
            <div class="panel-heading">
              <h4 class="panel-title">
                  সর্বশেষ অর্ডারঃ তারিখ ও সময়-{{ $lastOrder->created_at->format('F d, Y, h:i A') }}
              </h4>
            </div>
            <div class="panel-body">
              <h4>অর্ডার আইডিঃ {{ $lastOrder->payment_id }}</h4>
              <ul class="list-group">
                @foreach($lastOrder->cart->items as $item)
                  <li class="list-group-item">
                    {{ $item['item']['title'] }} | {{ $item['qty'] }}
                    <span class="badge">৳ {{ $item['price'] }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="panel-footer panel-footer-custom">
              <strong>মোট মূল্যঃ ৳ {{ $lastOrder->cart->totalPrice }}</strong>
            </div>
          </div>
        @endif
      @endforeach
    </div>
    <div class="col-md-4">
      <h3>আপনার অর্ডারগুলো</h3>
      <div class="panel-group" id="accordion">
      @foreach($orders as $order)
        <div class="panel panel-success">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $order->id }}">
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