@extends('partials.warehousepartials')

@section('title', 'পণ্যের শ্রেণিবিভাগ | ইকমার্স')

@section('warehousecontent')
  <div class="row">
    <div class="col-md-8">
      <h3><i class="fa fa-folder-open-o" aria-hidden="true"></i> পণ্যের শ্রেণিবিভাগ <span class="badge">{{ $categories->count() }}</span></h3>
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