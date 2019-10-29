@extends('adminlte::page')

@section('title', 'Categories & Subcategories | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Categories & Subcategories</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-success">
        <div class="panel-heading">
          Categories <span class="badge">{{ $categories->count() }}
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th width="30%">নাম</th>
                <th>Subcategories</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
            @foreach ($categories as $category)
              <tr>
                <td>{{ $category->name }}</td>
                <td>
                  @foreach ($category->subcategories as $subcategory)
                    <span class="label label-primary">{{ $subcategory->name }}</span>
                  @endforeach
                </td>
                <td>
                  <button class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </td>
              </tr>
            @endforeach
            </tbody>

          </table>
        </div>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">
          Subcategories <span class="badge">{{ $subcategories->count() }}
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>নাম</th>
                <th>Category</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
            @foreach ($subcategories as $subcategory)
              <tr>
                <td>{{ $subcategory->name }}</td>
                <td><span class="label label-primary">{{ $subcategory->category->name }}</span></td>
                <td>
                  <button class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </td>
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
      <div class="panel panel-primary">
        <div class="panel-heading">
          Add Subcategory
        </div>
        <div class="panel-body">
          {!! Form::open(['route' => 'warehouse.subcategories', 'method' => 'POST']) !!}
            {!! Form::label('name', 'Subcategory Name') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}

            {!! Form::label('category_id', 'Category Name') !!}
            <select name="category_id" class="form-control" required="">
              <option value="" selected="" disabled="">Select Category</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            {!! Form::submit('Add Subcategory', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@stop