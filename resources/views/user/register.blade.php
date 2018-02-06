@extends('layouts.master')

@section('content')
<div class="col-md-4 col-md-offset-4">
  <div class="panel panel-success">
    <div class="panel-heading"><span>রেজিস্টার</span></div>
    <div class="panel-body">
      {!! Form::open(['route' => 'user.register', 'method' => 'POST']) !!}
        {!! Form::label('name', 'নাম') !!}
        {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}

        {!! Form::label('phone', 'মোবাইল নম্বর') !!}
        {!! Form::text('phone', null, array('class' => 'form-control', 'required' => '')) !!}

        {!! Form::label('email', 'ইমেইল ঠিকানা') !!}
        {!! Form::text('email', null, array('class' => 'form-control', 'required' => '')) !!}

        {!! Form::label('address', 'পণ্য প্রেরণের ঠিকানা') !!}
        {!! Form::textarea('address', null, array('class' => 'form-control address', 'required' => '')) !!}

        {!! Form::label('password', 'পাসওয়ার্ড') !!}
        {!! Form::password('password', array('class' => 'form-control', 'required' => '')) !!}

        {!! Form::label('password_confirmation', 'পাসওয়ার্ড নিশ্চিত করুণ') !!}
        {!! Form::password('password_confirmation' , array('class' => 'form-control', 'required' => '')) !!}

        {!! Form::label('captcha', 'ক্যাপচা') !!}
        {!! app('captcha')->display() !!}

        {!! Form::submit('রেজিস্টার', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection