@extends('adminlte::page')

@section('title', 'পণ্যের শ্রেণিবিভাগ | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>পণ্যের শ্রেণিবিভাগ</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-success">
        <div class="panel-heading">
          পণ্যের শ্রেণিবিভাগ <span class="badge">{{ $categories->count() }}
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>নাম</th>
                <th>মুছে দিন</th>
              </tr>
            </thead>

            <tbody>
            @foreach ($categories as $category)
              <tr>
                <td>{{ $category->name }}</td>
                <td></td>
              </tr>
            @endforeach
            </tbody>

          </table>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          পণ্যের শ্রেণিবিভাগ যোগ করুণ
        </div>
        <div class="panel-body">
          {!! Form::open(['route' => 'warehouse.categories', 'method' => 'POST']) !!}
            {!! Form::label('name', 'শ্রেণিবিভাগের নাম') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
            {!! Form::submit('পণ্যের শ্রেণিবিভাগ যোগ করুন', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@stop