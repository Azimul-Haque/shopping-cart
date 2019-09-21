<!-- navigation panel -->
<nav class="navbar navbar-default navbar-fixed-top nav-transparent overlay-nav sticky-nav nav-border-bottom" role="navigation">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 pull-left">
                <a class="logo-light" href="{{ route('product.index') }}">
                    <img alt="" src="{{ asset('images/logo.png') }}" class="logo" />
                </a>
                <a class="logo-dark" href="{{ route('product.index') }}">
                    <img alt="" src="{{ asset('images/logo.png') }}" class="logo" />
                </a>
            </div>
            <!-- end logo -->
            <!-- toggle navigation -->
            <div class="navbar-header col-sm-8 col-xs-2 pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- toggle navigation end -->
            <!-- main menu -->
            <div class="col-md-8 no-padding-right accordion-menu text-right">
                <div class="navbar-collapse collapse">
                    <ul id="accordion" class="nav navbar-nav navbar-right panel-group">
                        <li>
                            <a href="{{ route('product.index') }}" class="inner-link">Home</a>
                        </li>
                        
                        <li>
                            <a href="{{ route('index.about') }}" class="inner-link">About Us</a>
                        </li>
                        
                        {{-- <li class="dropdown panel simple-dropdown">
                            <a href="#nav_archive" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                Archive ▽
                            </a>
                            <ul id="nav_archive" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.publications') }}"><i class="icon-newspaper i-plain"></i> Publications</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.disasterdata') }}"><i class="icon-cloud i-plain"></i> Data</a>
                                </li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="{{ route('index.contact') }}">Contact</a>
                        </li>
                        {{-- <li class="dropdown panel simple-dropdown">
                            <a href="#others_dropdown" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">Others ▽
                            </a>
                            <ul id="others_dropdown" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.news') }}"><i class="icon-newspaper i-plain"></i> News</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.events') }}"><i class="icon-megaphone i-plain"></i> Events</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.gallery') }}"><i class="icon-pictures i-plain"></i> Photo Gallery</a>
                                </li>
                            </ul>
                        </li> --}}
                        @if(Auth::check())
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_auth_user" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                @php
                                    $nav_user_name = explode(' ', Auth::user()->name);
                                    $last_name = array_pop($nav_user_name);
                                @endphp
                                {{ $last_name }} ▽
                            </a>
                            <!-- sub menu single -->
                            <!-- sub menu item  -->
                            <ul id="nav_auth_user" class="dropdown-menu panel-collapse collapse" role="menu">
                                @if(Auth::user()->role == 'admin')
                                <li>
                                    <a href="{{ route('warehouse.dashboard') }}"><i class="icon-speedometer i-plain"></i> Dashboard</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('user.profile', Auth::user()->unique_key) }}"><i class="icon-profile-male i-plain"></i> Profile</a>
                                </li>
                                <li>
                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}"><i class="icon-key i-plain"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li>
                            <a href="{{ url('login') }}" class="inner-link">Login</a>
                        </li>
                        @endif
                        <!-- end menu item -->
                    </ul>
                </div>
            </div>
            <!-- end main menu -->
            <!-- search and cart  -->
            <div class="col-md-2 no-padding-left search-cart-header pull-right">
                {{-- <div id="top-search">
                    <a href="#search-header" class="header-search-form"><i class="fa fa-search search-button"></i></a>
                </div>
                <form id="search-header" method="post" action="#" name="search-header" class="mfp-hide search-form-result">
                    <div class="search-form position-relative">
                        <button type="submit" class="fa fa-search close-search search-button"></button>
                        <input type="text" name="search" class="search-input" placeholder="Enter your keywords..." autocomplete="off">
                    </div>
                </form> --}}
                <!-- end search input -->
                <div class="top-cart">
                    <!-- nav shopping bag -->
                    <a href="{{ route('product.shoppingcart') }}"> {{-- class="shopping-cart" --}}
                        <i class="fa fa-shopping-cart"></i><span class="visible-sm visible-xs" style="float: right;">(<span class="" id="totalInBagMobile">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>)</span>
                        <div class="subtitle">(<span class="" id="totalInBag">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>) Items</div>
                    </a>{{-- 
                    <li>
                      <a href="{{ route('product.shoppingcart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                        বাজারের ব্যাগ
                        <span class="badge" id="totalInBag">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                      </a>
                    </li> --}}
                    
                    <!-- end nav shopping bag -->
                    <!-- shopping bag content -->
                    {{-- <div class="cart-content">
                        <ul class="cart-list">
                            <li>
                                <a title="Remove item" class="remove" href="#">×</a>
                                <a href="#">
                                    <img width="90" height="90" alt="" src="images/shop-cart.jpg">Leather Craft
                                </a>
                                <span class="quantity">1 × <span class="amount">$160</span></span>
                                <a href="#">Edit</a>
                            </li>
                        </ul>
                        <p class="total">Total Items: <span class="amount">$160</span></p>
                        <p class="buttons">
                            <a href="#" class="btn btn-very-small-white no-margin-bottom margin-seven pull-left no-margin-lr">View Cart</a>
                            <a href="shop-checkout.html" class="btn btn-very-small-white no-margin-bottom margin-seven no-margin-right pull-right">Checkout</a>
                        </p>
                    </div> --}}
                    <!-- end shopping bag content -->
                </div>
            </div>
            <!-- end search and cart  -->
        </div>
    </div>
</nav>
<!--end navigation panel-->