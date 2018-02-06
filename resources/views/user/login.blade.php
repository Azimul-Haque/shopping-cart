@extends('layouts.master')

@section('content')
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-success">
      <div class="panel-heading"><span>লগিন</span></div>
      <div class="panel-body">
        <form action="{{ route('user.login') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="phoneoremail">ইমেইল অথবা ফোন নাম্বার</label>
            <input class="form-control" type="text" id="phoneoremail" name="phoneoremail">
          </div>
          <div class="form-group">
            <label for="password">পাসওয়ার্ড</label>
            <input class="form-control" type="password" id="password" name="password">
          </div>
          <button type="submit" class="btn btn-primary">লগইন</button>
        </form>
        <p>আপনার কি একাউন্ট নেই? এখুনই <a href="{{ route('user.register') }}">রেজিস্টার</a> করুন</p>
      </div>
    </div>
  </div>
@endsection