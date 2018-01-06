@extends('layouts.master')

@section('content')
<dir class="row">
  <div class="col-md-4 col-md-offset-4">
    <h1>Login</h1>
    <form action="{{ route('user.login') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="text" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</dir>
@endsection