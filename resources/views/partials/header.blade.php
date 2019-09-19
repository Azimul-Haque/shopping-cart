@if(Auth::check() && Auth::user()->role == 'admin')
<script type="text/javascript">
  var orders=0;
  var oldOrders=0;
  function currentBalanceInquery(data) {
   $.ajax({
       url: "/warehouse/getdueorders/api",
       type: "GET",
       data: {},
       success: function (data) {
         var orders = data;
         var oldOrders = $("#dueOrders").text();
         console.log(orders);
         console.log(oldOrders);
         var notify = new Audio('/sounds/notification.mp3');
         if(orders != oldOrders) {
           // notify.play();
           toastr.info('নতুন অর্ডার এসেছে!', 'তথ্য (INFO)').css('width','400px');
         }
         if(orders < 0) {
          orders = 0;
         }
         var currentdate = new Date(); 
         var datetime = "Last Sync: " + currentdate.getDate() + "/"
                         + (currentdate.getMonth()+1)  + "/" 
                         + currentdate.getFullYear() + " @ "  
                         + currentdate.getHours() + ":"  
                         + currentdate.getMinutes() + ":" 
                         + currentdate.getSeconds();
         $("#dueOrders").text(orders);
         console.log(datetime);
         
       }
   });
  }
  setTimeout(currentBalanceInquery(), 1000*1);
  setInterval(currentBalanceInquery, 1000*100);
</script>
@endif
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('product.index') }}">ইকমার্স</a>
      <div class="nav navbar-brand pull-right bagIconInMobile visible-xs">
        <a href="{{ route('product.shoppingcart') }}" class="">
          <i class="fa fa-shopping-bag" aria-hidden="true"></i>
          <span class="badge badge-notify" id="totalInBagMobile">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
        </a>
      </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="{{ route('product.shoppingcart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> 
            বাজারের ব্যাগ
            <span class="badge" id="totalInBag">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
          </a>
        </li>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <li class="{{ Request::is('warehouse/*') ? '': '' }}"><a href="{{ route('warehouse.dueorders') }}"><i class="fa fa-bell-o" aria-hidden="true"></i> অর্ডারগুলো <span class="badge" id="dueOrders">{{ $due_orders }}</span></a></li>
        <li class="{{ Request::is('warehouse/*') ? 'active': '' }}"><a href="{{ route('warehouse.dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> ড্যাশবোর্ড</a></li>
        @endif
        @if(Auth::check())
          <li class="{{ Request::is('user/*') ? 'dropdown active': 'dropdown' }}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('user.profile') }}"><i class="fa fa-user" aria-hidden="true"></i> প্রোফাইল</a></li>
              <li><a href="#"><i class="fa fa-ticket" aria-hidden="true"></i> ইউজার আইডিঃ <b>{{ Auth::user()->code }}</b></a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('user.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> লগ আউট</a></li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('user.login') }}">লগইন</a></li>
          <li><a href="{{ route('user.register') }}">রেজিস্টার</a></li>
        @endif
      </ul>
      <form accept-charset="UTF-8" class="search-in-navbar">
        <div class="input-group add-on">
            <input class="form-control" name="search" type="search" autocomplete="on"  placeholder="অনুসন্ধান (দুধ, ডিম, পাউরুটি ইত্যাদি)" id="search-content">
          <div class="input-group-btn">
            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
          </div>
        </div>
      </form>
      <script type="text/javascript">
        var options = {
          url: "/autocomplete",

          getValue: "title",

          template: {
            type: "custom",
            method: function(value, item) {
              return "<div style='overflow: auto;'>"+value + " - <span style='color:gray;'>৳ "+item.price+"</span><img src='/images/product-images/" + item.imagepath + "' style='height:50px;width:auto;float:right;'/></div>";
            }
          },

          list: {
            match: {
              enabled: true
            }
          }
        };

        $("#search-content").easyAutocomplete(options);
      </script>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
