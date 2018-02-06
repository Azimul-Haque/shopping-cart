@extends('layouts.master')

@section('title', 'সাউদিয়া সুপার শপ')

@section('content')
  <div class="row">
    <div class="col-md-2">
      @include('partials/shop-sidebar')
    </div>
    <div class="col-md-10">
      <div class="col-md-6 col-md-offset-2">
        <h2>অর্ডারটি নিশ্চিত করুন</h2>
        <h3>ক্রেতার নামঃ {{ Auth::user()->name }}</h3>
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
          {!! Form::text('address', Auth::user()->address, array('class' => 'form-control')) !!}

          {!! Form::submit('আপনার অর্ডারটি নিশ্চিত করুন', array('class' => 'btn btn-success', 'style' => 'margin-top:20px;')) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection