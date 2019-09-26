@extends('adminlte::page')

@section('title', 'Edit Admin | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Edit Admin
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h4>
            Edit Admin (Update Name/ Password)
          </h4>
        </div>
        {!! Form::model($admin, ['route' => ['admin.updateadmin', $admin->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            {!! Form::label('name', 'Admin Name *') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            {!! Form::label('phone', 'Phone Number') !!}
            {!! Form::text('phone', null, array('class' => 'form-control', 'readonly' => '')) !!}<br/>

            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', null, array('class' => 'form-control', 'readonly' => '')) !!}<br/>

            {!! Form::label('password', 'Password *') !!}
            {!! Form::password('password', array('class' => 'form-control', 'id' => 'password', 'required' => '', 'autocomplete' => 'off')) !!}<br/>
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-info">Update</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">
    setTimeout(function(){ 
      $('#password').val('');
    }, 500);
  </script>
@stop