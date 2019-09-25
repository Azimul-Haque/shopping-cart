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
  <div class="row">
		<div class="col-md-6">
		    <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
		        <div class="box-header ui-sortable-handle" style="">
		          <i class="fa fa-calculator"></i>

		          <h3 class="box-title">Last 7 Days' Sales</h3>
		          <div class="box-tools pull-right text-muted">
		            {{ date('F Y') }}
		          </div>
		        </div>
		        <!-- /.box-header -->
		        <div class="box-body">
		          <canvas id="myChartC"></canvas>
		        </div>
		        <!-- /.box-body -->
		    </div>
        </div>
  </div>
@endsection

@section('js')
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    	<script type="text/javascript">
          var ctx = document.getElementById('myChartC').getContext('2d');
          var chart = new Chart(ctx, {
              // The type of chart we want to create
              type: 'line',
              // The data for our dataset
              data: {
                  labels: {!! $datesforchartc !!},
                  datasets: [{
                      label: '',
                      borderColor: "#3e95cd",
                      fill: true,
                      data: {!! $totalsforchartc !!},
                      borderWidth: 2,
                      borderColor: "rgba(0,165,91,1)",
                      borderCapStyle: 'butt',
                      pointBorderColor: "rgba(0,165,91,1)",
                      pointBackgroundColor: "#fff",
                      pointBorderWidth: 1,
                      pointHoverRadius: 5,
                      pointHoverBackgroundColor: "rgba(0,165,91,1)",
                      pointHoverBorderColor: "rgba(0,165,91,1)",
                      pointHoverBorderWidth: 2,
                      pointRadius: 5,
                      pointHitRadius: 10,
                  }]
              },
              // Configuration options go here
              options: {
                legend: {
                        display: false
                },
                elements: {
                    line: {
                        tension: 0
                    }
                }
              }
          });
      </script>
@stop