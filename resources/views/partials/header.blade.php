<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('product.index') }}">Saudia Super Shop</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart</a></li>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <li><a href="{{ route('product.add') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add Product</a></li>@endif
        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> User Name <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('user.profile') }}">Profile</a></li>
              <li><a href="#">Cart</a></li>
              <li><a href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Preivous Orders</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('user.logout') }}">Log out</a></li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('user.login') }}">Login</a></li>
          <li><a href="{{ route('user.register') }}">Register</a></li>
        @endif
      </ul>
      <form accept-charset="UTF-8" class="navbar-form navbar-left" >
        <div class="input-group add-on">
            <input class="form-control parsley-error" placeholder="অনুসন্ধান " name="search" type="text" required="" data-parsley-required-message="" data-parsley-id="9">
          <div class="input-group-btn">
            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
          </div>
        </div>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>