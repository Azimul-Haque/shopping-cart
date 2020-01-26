@extends('layouts.index')

@section('title', 'LOYAL অভিযাত্রী | আপনার প্রয়োজন শুধু বলুন, আমরা পৌঁছে যাবো আপনার দরজায়।')

@section('css')
  <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>

  <style type="text/css">
      body {
          overflow: hidden;
      }

      /* Preloader */
      #preloader {
          position: fixed;
          top:0;
          left:0;
          right:0;
          bottom:0;
          background-color:#fff; /* change if the mask should have another color then white */
          z-index:99999;
      }

      #status {
          width:200px;
          height:200px;
          position:absolute;
          left:50%;
          top:50%;
          background-image:url({{ asset('images/3362406.gif') }}); /* path to your loading animation */
          background-repeat:no-repeat;
          background-position:center;
          margin:-100px 0 0 -100px;
      }
      .subcategory_list_box {
        text-align: center;
      }
      .subcategory_list_ul {
        height: 557px; 
        overflow-y: auto;
      }
      .subcategory_list_ul li {
        padding: 10px;
        border-bottom: 1px solid #e5e5e5;
      }
      .products_card {
        min-height: 640px; 
      }
      .sm_xs_products_header {
        text-align: center;
        padding: 30px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      }
  </style>
@endsection

@section('content')
  {{-- <div id="preloader">
      <div id="status">&nbsp;</div>
  </div> --}}
  @include('partials._slider')

  <!-- about section -->
  <section class="wow fadeIn">
      <div class="container">
          <div class="row">
              <div class="col-md-6 col-sm-10 text-center center-col">
                  {{-- <span class="margin-five no-margin-top display-block letter-spacing-2">EST. 2018</span> --}}
                  <h2>LOYAL অভিযাত্রী</h2>
                  <p class="text-med width-90 center-col margin-seven no-margin-bottom">
                    আপনার প্রয়োজন শুধু বলুন, আমরা পৌঁছে যাবো আপনার দরজায়...
                  </p>
              </div>
          </div>
      </div>
  </section>
  <!-- end about section -->
  <!-- product section -->
  <section class="padding-three bg-gray">
      <div class="container">
          <div class="row">
              <!-- section title -->
              <div class="col-md-6 col-sm-6">
                  <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">Products</span>
              </div>
              <!-- end section title -->
              <!-- section highlight text -->
              <div class="col-md-6 col-sm-6 text-right xs-text-left">
              </div>
              <!-- end section highlight text -->
          </div>
      </div>
  </section>

  <!-- content section -->
  <section class="padding-three">
      <div class="container">
          @php
            $categorytitlecolors = ['#ff8a80', '#ea80fc', '#b9f6ca', '#f4ff81', '#ffd180', '#00e676', '#1de9b6', '#80d8ff', '#f8bbd0', '#76ff03', '#ff6f00', '#bcaaa4', '#90a4ae', '#c5e1a5', '#18ffff', '#82b1ff']
          @endphp
          @foreach($categories as $category)
            @php
              $totalproductofthiscat = 0;
              foreach($category->subcategories as $subcategory) {
                if($subcategory->isAvailable == 1) {
                  foreach ($subcategory->products as $product) {
                    if($product->isAvailable == 1) {
                      $totalproductofthiscat = $totalproductofthiscat + 1;
                    }
                  }
                }
              }
            @endphp
            @if($category->products->count() > 0 && $totalproductofthiscat > 0)
              @php
                $colornow = $categorytitlecolors[array_rand($categorytitlecolors)];
              @endphp
              <div class="row margin-three">
                <div class="col-md-3 hidden-sm hidden-xs">
                  <div class="subcategory_list_box shadow-light" style="border-bottom: 4px solid {{ $colornow  }}">
                      <div class="pricing-title" style="background: {{ $colornow  }};">
                          <h3>{{ $category->name }}</h3>
                      </div>
                      <ul class="subcategory_list_ul">
                        @foreach($category->subcategories as $subcategory)
                          @php
                            $totalproductofthissubcat = 0;
                            if($subcategory->isAvailable == 1) {
                              foreach ($subcategory->products as $product) {
                                if($product->isAvailable == 1) {
                                  $totalproductofthissubcat = $totalproductofthissubcat + 1;
                                }
                              }
                            }
                          @endphp
                          @if($subcategory->isAvailable == 1 && $totalproductofthissubcat > 0)
                          <a href="{{ route('product.subcategorywise', [$subcategory->id, generate_token(100)]) }}">
                            <li>{{ $subcategory->name }} ({{ $totalproductofthissubcat }})</li>
                          </a>
                          @endif
                        @endforeach
                      </ul>
                  </div>
                </div>
                <div class="col-md-9 col-sm-12">
                  <div class="shadow-light products_card" style="border-bottom: 4px solid {{ $colornow  }}">
                    <div class="row">
                      <div class="col-sm-12 sm_xs_products_header visible-sm visible-xs" >
                        <h3>{{ $category->name }}</h3>
                      </div>
                      @foreach($category->products->take(6) as $product)
                        @if($product->isAvailable == 1)
                        <!-- shop item -->
                        <div class="col-md-4 col-sm-4" style="min-height: 320px;">
                            <div class="home-product text-center position-relative overflow-hidden margin-ten no-margin-top">
                                <a href="{{ route('product.getsingleproduct', [$product->id, generate_token(100)]) }}"><img src="{{ asset('images/product-images/'.$product->productimages->first()->image) }}" alt="{{ $product->title }}"></a>
                                <span class="product-name text-uppercase"><a href="{{ route('product.getsingleproduct', [$product->id, generate_token(100)]) }}" class="bg-white">{{ $product->title }}</a></span>
                                <span class="price black-text">
                                  @if($product->oldprice > 0)
                                    <del>৳ {{ $product->oldprice }}</del>
                                  @endif
                                  ৳ {{ $product->price }}
                                </span>
                                {{-- <span class="onsale onsale-style-2">Sale</span> --}}
                                <div class="quick-buy">
                                    <div class="product-share">
                                        {{-- <a href="#" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn" title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                        <a href="#" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn" title="Add to Compare"><i class="fa fa-refresh"></i></a> --}}
                                        <button id="addToCart{{ $product->id }}" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn" title="Add to Cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end shop item -->
                        <script type="text/javascript">
                          $(document).ready(function(){
                              $("#addToCart{{ $product->id }}").click(function(){
                                console.log('Item ID: {{ $product->id }}');
                                $.ajax({
                                    url: "/addtocart/{{ $product->id }}",
                                    type: "GET",
                                    data: {},
                                    success: function (data) {
                                      var response = data;
                                      console.log(response);
                                      if(response == 'success') {
                                        if($(window).width() > 768) {
                                          toastr.success('{{ $product->title }} আপনার ব্যাগে যুক্ত করা হয়েছে।', 'সফল (SUCCESS)').css('width','400px');
                                        } else {
                                          toastr.success('{{ $product->title }} আপনার ব্যাগে যুক্ত করা হয়েছে।', 'সফল (SUCCESS)').css('width', ($(window).width()-25)+'px');
                                        }
                                      }
                                      var totalInBag = parseInt($("#totalInBag").text());
                                      if(isNaN(totalInBag)) {
                                        totalInBag = 0;
                                      } else {
                                        totalInBag = totalInBag;
                                      }
                                      totalInBag = totalInBag + 1;
                                      $("#totalInBag").text(totalInBag);
                                      
                                      var totalInBagMobile = parseInt($("#totalInBagMobile").text());
                                      if(isNaN(totalInBagMobile)) {
                                        totalInBagMobile = 0;
                                      } else {
                                        totalInBagMobile = totalInBagMobile;
                                      }
                                      totalInBagMobile = totalInBagMobile + 1;
                                      $("#totalInBagMobile").text(totalInBagMobile);
                                    }
                                });
                              });
                          });
                        </script>
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
<!-- Preloader -->
<script type="text/javascript">
    //<![CDATA[
        $(window).load(function() { // makes sure the whole site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(1000).css({'overflow':'visible'});
        })
    //]]>
</script>
<script>
    $("#owl-demo").owlCarousel ({
        slideSpeed : 800,
        autoPlay: 4000,
        items : 1,
        stopOnHover : false,
        itemsDesktop : [1199,1],
        itemsDesktopSmall : [979,1],
        itemsTablet :   [768,1],
        rewindNav: false
      });
</script>
<script type="text/javascript">
  $('#search-content').on('keyup', function () {
      //history.pushState(null, null, '/search');
      $("#products_list").hide();
      $("#searched_list").show();
      if($('#search-content').val().length == 0) {
        $("#products_list").show();
        $("#searched_list").hide();
      }
      $value = $(this).val().trim();;
      $.ajax({
          url: "{{ URL::to('search') }}",
          type: "GET",
          data: {'search':$value},
          success: function (data) {
            $("#searched_list").html(data);
          }
      });
  });
  function s_addToCart(id) {
      console.log('Item ID:'+id);
      $title = $('#s_addToCart'+id).data('title');
      console.log('Item Title:'+$title);
      $.ajax({
          url: "/addtocart/"+id,
          type: "GET",
          data: {},
          success: function (data) {
            var response = data;
            console.log(response);
            if(response == 'success') {
              toastr.success($title+' আপনার ব্যাগে যুক্ত করা হয়েছে।', 'সফল (SUCCESS)').css('width','400px');
            }
            var totalInBag = parseInt($("#totalInBag").text());
            if(isNaN(totalInBag)) {
              totalInBag = 0;
            } else {
              totalInBag = totalInBag;
            }
            totalInBag = totalInBag + 1;
            $("#totalInBag").text(totalInBag);
            var totalInBagMobile = parseInt($("#totalInBagMobile").text());
            if(isNaN(totalInBagMobile)) {
              totalInBagMobile = 0;
            } else {
              totalInBagMobile = totalInBagMobile;
            }
            totalInBagMobile = totalInBagMobile + 1;
            $("#totalInBagMobile").text(totalInBagMobile);
          }
      });
  }
</script>
@endsection