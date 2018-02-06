@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-2">
      <div class="row">
        <div class="btn-group-vertical col-md-12" role="group" aria-label="...">
          <button type="button" class="btn btn-success btn-block"><i class="fa fa-tachometer" aria-hidden="true"></i> এডমিন ড্যাশবোর্ড</button>
          <a href="{{ route('warehouse.dashboard') }}" class="btn btn-default btn-block">ড্যাশবোর্ড</a>
          <a href="{{ route('warehouse.dueorders') }}" class="btn btn-default btn-block"><i class="fa fa-list-ol" aria-hidden="true"></i> আজকের অর্ডারগুলো <span class="label label label-primary">{{ $due_orders }}</span></a>
          <a href="{{ route('warehouse.addproduct') }}" class="btn btn-default btn-block"><i class="fa fa-plus" aria-hidden="true"></i> পণ্য যোগ করুণ</a>
          <a href="{{ route('warehouse.categories') }}" class="btn btn-default btn-block"><i class="fa fa-folder-open-o" aria-hidden="true"></i> পণ্যের শ্রেণীবিভাগ</a>
          <a href="#" class="btn btn-default btn-block"><i class="fa fa-line-chart" aria-hidden="true"></i> রিপোর্ট</a>
          <a href="#" class="btn btn-default btn-block"><i class="fa fa-sign-out" aria-hidden="true"></i> লগআউট</a>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <div class="row">
        @yield('warehousecontent')
      </div>
    </div>
  </div>
@endsection