@extends('adminlte::page')

@section('title', 'ড্যাশবোর্ড | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>ড্যাশবোর্ড</h1>
@stop

@section('content')
  <div class="row">
  	<div class="col-md-3 col-xs-6">
  		<div class="small-box bg-aqua">
	        <div class="inner">
	          <h3>{{ $totalorders }}<sup style="font-size: 20px">টি</sup></h3>

	          <p>মোট অর্ডার</p>
	        </div>
	        <div class="icon">
	          <i class="fa fa-shopping-cart"></i>
	        </div>
	        <a href="{{ route('warehouse.dueorders') }}" class="small-box-footer">পেন্ডিং অর্ডার দেখুন <i class="fa fa-arrow-circle-right"></i></a>
	    </div>
  	</div>
  	<div class="col-md-3 col-xs-6">
  		<div class="small-box bg-green">
	        <div class="inner">
	          <h3>{{ $totalincome }}<sup style="font-size: 20px">৳</sup></h3>

	          <p>মোট আয়</p>
	        </div>
	        <div class="icon">
	          <i class="fa fa-bar-chart"></i>
	        </div>
	        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	    </div>
  	</div>
  	<div class="col-md-3 col-xs-6">
  		<div class="small-box bg-yellow">
	        <div class="inner">
	          <h3>{{ $totalcustomers }} <sup style="font-size: 20px">জন</sup></h3>

	          <p>মোট কাস্টমার</p>
	        </div>
	        <div class="icon">
	          <i class="fa fa-user-plus"></i>
	        </div>
	        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	    </div>
  	</div>
  	<div class="col-md-3 col-xs-6">
  		<div class="small-box bg-red">
	        <div class="inner">
	          <h3>{{ $totalproducts }}</h3>

	          <p>পণ্য সংখ্যা</p>
	        </div>
	        <div class="icon">
	          <i class="fa fa-pie-chart"></i>
	        </div>
	        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	    </div>
  	</div>
  </div>
@endsection

@section('js')
    
@stop