@extends('adminlte::page')

@section('title', 'Add Admin | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>Add Admin
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h4>
            Add Admin
          </h4>
        </div>
        {!! Form::open(['route' => 'admin.storeadmin', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            {!! Form::label('name', 'Admin Name *') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            {!! Form::label('phone', 'Phone Number *') !!}
            {!! Form::text('phone', null, array('class' => 'form-control', 'required' => '', "onkeypress" => "if(this.value.length==11) return false;")) !!}<br/>

            {!! Form::label('email', 'Email *') !!}
            {!! Form::email('email', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            {!! Form::label('password', 'Password *') !!}
            {!! Form::password('password', array('class' => 'form-control', 'required' => '')) !!}<br/>
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection

@section('js')

@stop