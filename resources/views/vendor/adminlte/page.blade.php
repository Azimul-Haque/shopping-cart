@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li class="tasks-menu">
                            <a href="{{ url('/') }}" target="_blank" title="View Website" data-placement="bottom">
                                <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
                            </a>
                        </li>
                        @if(Auth::user()->role == 'admin') {{-- eita apatoto, karon kichudin por eita normal user er jonnou kora hobe --}}
                        <li class="dropdown notifications-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell-o"></i>
                            @if($due_orders > 0)
                              <span class="label label-warning">{{ $due_orders }}</span> {{-- eta change hobe, aro notification add hobe --}}
                            @endif
                            {{-- @if($notifcount > 0)
                            <span class="label label-warning">{{ $notifcount }}</span>
                            @endif --}}
                          </a>
                          <ul class="dropdown-menu">
                            {{-- @if($notifcount > 0)
                              <li class="header">{{ $notifcount }} টি নোটিফিকেশন আছে</li>
                            @else
                              <li class="header">কোন নোটিফিকেশন নেই!</li>
                            @endif --}}
                            
                            <li>
                              <!-- inner menu: contains the actual data -->
                              <ul class="menu">
                                @if($due_orders > 0)
                                <li>
                                  <a href="{{ route('warehouse.dueorders') }}">
                                    <i class="fa fa-file-text-o text-aqua"></i> {{ $due_orders }} টি পেন্ডিং অর্ডার
                                  </a>
                                </li>
                                @endif
                                
                                {{-- @if($notifpendingapplications > 0)
                                  <li>
                                    <a href="{{ route('dashboard.applications') }}">
                                      <i class="fa fa-users text-aqua"></i> {{ $notifpendingapplications }} জন নিবন্ধন আবেদন করেছেন
                                    </a>
                                  </li>
                                @endif

                                @if($notifdefectiveapplications > 0)
                                  <li>
                                    <a href="{{ route('dashboard.defectiveapplications') }}">
                                      <i class="fa fa-exclamation-triangle text-maroon"></i> {{ $notifdefectiveapplications }} টি অসম্পূর্ণ আবেদন আছে
                                    </a>
                                  </li>
                                @endif

                                @if($notifpendingpayments > 0)
                                  <li>
                                    <a href="{{ route('dashboard.memberspendingpayments') }}">
                                      <i class="fa fa-hourglass-start text-yellow"></i> {{ $notifpendingpayments }} টি প্রক্রিয়াধীন পরিশোধ রয়েছে
                                    </a>
                                  </li>
                                @endif

                                @if($notiftempmemdatas > 0)
                                  <li>
                                    <a href="{{ route('dashboard.membersupdaterequests') }}">
                                      <i class="fa fa-pencil-square-o text-green"></i> {{ $notiftempmemdatas }} টি তথ্য হালনাগাদ অনুরোধ
                                    </a>
                                  </li>
                                @endif 

                                @if($notifsmsbalance > 0 && $notifsmsbalance < 21)
                                  <li>
                                    <a href="#">
                                      <i class="fa fa-envelope-o text-red"></i> অপর্যাপ্ত SMS ব্যালেন্সঃ ৳ {{ $notifsmsbalance }}
                                    </a>
                                  </li>
                                @endif     --}}                            
                              </ul>
                            </li>
                            <li class="footer"><a href="#!">সব দেখুন</a></li>
                          </ul>
                        </li>
                        @endif
                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            @if((Auth::User()->image != '') && (file_exists(public_path('images/users/'.Auth::User()->image))))
                              <img src="{{ asset('images/users/'.Auth::User()->image)}}" class="user-image" alt="{{ Auth::User()->name }}-এর মুখছবি">
                            @else
                              <img src="{{ asset('images/user.png')}}" class="user-image" alt="{{ Auth::User()->name }}-এর মুখছবি">
                            @endif
                            
                            {{ Auth::User()->name }}</a>
                            <ul class="dropdown-menu" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                              <!-- User image -->
                              <li class="user-header">
                                @if((Auth::User()->image != '') && (file_exists(public_path('images/users/'.Auth::User()->image))))
                                  <img src="{{ asset('images/users/'.Auth::User()->image)}}" class="img-circle" alt="{{ Auth::User()->name }}-এর মুখছবি">
                                @else
                                  <img src="{{ asset('images/user.png') }}" class="img-circle" alt="{{ Auth::User()->name }}-এর মুখছবি">
                                @endif
                                <p>
                                  {{ Auth::User()->name }}
                                  <small>সদস্যপদ প্রাপ্তিঃ {{ date('F, Y', strtotime(Auth::User()->created_at)) }}</small>
                                </p>
                              </li>
                              <!-- Menu Body -->
               
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-left">
                                  <a href="{{ route('user.profile', Auth::user()->unique_key) }}" class="btn btn-default btn-flat"><i class="fa fa-fw fa-user-o"></i> প্রোফাইল</a>
                                </div>
                                <div class="pull-right">
                                  @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                      <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> লগ আউট
                                      </a>
                                  @else
                                      <a href="#"
                                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> লগ আউট
                                      </a>
                                      <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;" class="btn btn-default btn-flat">
                                          @if(config('adminlte.logout_method'))
                                              {{ method_field(config('adminlte.logout_method')) }}
                                          @endif
                                          {{ csrf_field() }}
                                      </form>
                                  @endif
                                </div>
                              </li>
                            </ul>                            
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    {{-- @each('adminlte::partials.menu-item', $adminlte->menu(), 'item') --}}
                    @if(Auth::user()->role == 'admin')
                      <li class="header">DASHBOARD</li>
                      <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.dashboard') }}">
                              <i class="fa fa-fw fa-tachometer"></i>
                              <span>Dashboard</span>
                          </a>
                      </li>
                      <li class="header">ADMIN ACTIVITY</li>
                      <li class="{{ Request::is('admin/admins') ? 'active' : '' }}">
                          <a href="{{ route('admin.admins') }}">
                              <i class="fa fa-fw fa-cogs"></i>
                              <span>Admins</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                          <a href="{{ route('admin.settings') }}">
                              <i class="fa fa-fw fa-wrench"></i>
                              <span>Settings</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('admin/pages') ? 'active' : '' }}">
                          <a href="{{ route('admin.pages') }}">
                              <i class="fa fa-fw fa-files-o"></i>
                              <span>Pages</span>
                          </a>
                      </li>
                      <li class="header">WAREHOUSE</li>
                      <li class="{{ Request::is('warehouse/dueorders') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.dueorders') }}">
                              <i class="fa fa-fw fa-list-ol"></i>
                              <span>Pending Orders</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/inprogressorders') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.inprogressorders') }}">
                              <i class="fa fa-fw fa-hourglass-half"></i>
                              <span>In Progress Orders</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/deliveredorders') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.deliveredorders') }}">
                              <i class="fa fa-fw fa-check-square-o"></i>
                              <span>Delivered Orders</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/products') ? 'active' : '' }} {{ Request::is('warehouse/products/*') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.products') }}">
                              <i class="fa fa-fw fa-truck"></i>
                              <span>Products</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/categories') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.categories') }}">
                              <i class="fa fa-fw fa-folder-open-o"></i>
                              <span>Category & Sub-category</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/customers') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.customers') }}">
                              <i class="fa fa-fw fa-users"></i>
                              <span>Customer List</span>
                          </a>
                      </li>
                      <li class="{{ Request::is('warehouse/reviews') ? 'active' : '' }}">
                          <a href="{{ route('warehouse.reviews') }}">
                              <i class="fa fa-fw fa-star-half-o"></i>
                              <span>Product Reviews</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="#!">
                              <i class="fa fa-fw fa-line-chart"></i>
                              <span>Report</span>
                          </a>
                      </li>
                    @endif
                    
                    {{-- <li class="{{ Request::is('dashboard/member/user/manual') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.memberusermanual') }}">
                            <i class="fa fa-fw fa-umbrella"></i>
                            <span>ব্যবহার বিধি</span>
                        </a>
                    </li> --}}
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.28
          </div>
          <strong>Copyright © {{ date('Y') }}</strong> 
          All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript">
      $(function(){
       $('a[title]').tooltip();
       $('button[title]').tooltip();
      });
    </script>
    @stack('js')
    @yield('js')
@stop
