@extends('layouts.index')

@section('title', 'About Us | LOYAL অভিযাত্রী')

@section('css')
  <style type="text/css">
    .padding-bottom-ten {
      padding-bottom: 10%;
    }
    .big-text {
      font-size: 20px;
      text-align: justify;
      text-justify: inter-word;
    }
  </style>
@endsection

@section('content')
  <!-- product section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <!-- section title -->
              <div class="col-md-6 col-sm-6">
                  <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">About Us</span>
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
          <div class="row">
              <div class="col-sm-9 col-sm-push-3">
                  
                  <div class="row border-bottom padding-bottom-ten">
                      <div class="col-md-12 text-center">
                          <h3 class="section-title">Assalamu Alaikum</h3>
                      </div>
                      <div class="col-md-12">
                          <p class="big-text">
                            You shall find here the best care products for your hair and skin, smartest available gadgets and
                            tasty treats to your sweet teeth. At a reasonable price, we assure you loyalty in our service and
                            authenticity in our products.<br/><br/>
                            So, start your journey with <b>LOYAL অভিযাত্রী</b> and we will keep providing you with the best
                            products available, in shaa Allah!
                          </p>
                      </div>
                  </div>
                  {{-- related product --}}
                  {{-- related product --}}
                  <div class="row padding-ten">
                      <div class="col-md-12 text-center">
                          <h3 class="section-title">NEW ARRIVALS</h3>
                      </div>
                  </div>
                  <div class="row">
                      <!-- related products slider -->
                      <div id="shop-products" class="owl-carousel owl-theme dark-pagination owl-no-pagination owl-prev-next-simple">
                        @foreach($recentproducts as $recentproduct)
                          <!-- shop item -->
                          <div class="item">
                              <div class="home-product text-center position-relative overflow-hidden">
                                  <a href="{{ route('product.getsingleproduct', [$recentproduct->id, generate_token(100)]) }}"><img src="{{ asset('images/product-images/'.$recentproduct->productimages->first()->image) }}" alt=""/></a>
                                  <span class="product-name text-uppercase"><a href="{{ route('product.getsingleproduct', [$recentproduct->id, generate_token(100)]) }}">{{ $recentproduct->title }}</a></span>
                                  <span class="price black-text">
                                    @if($recentproduct->oldprice)
                                    <del>৳ {{ $recentproduct->oldprice }}</del>
                                    @endif
                                    ৳ {{ $recentproduct->price }}
                                  </span>
                                  {{-- <div class="quick-buy">
                                      <div class="product-share">
                                          <a href="#" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn" title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                          <a href="#" class="highlight-button-dark btn btn-small no-margin-right quick-buy-btn" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                      </div>
                                  </div> --}}
                              </div>
                          </div>
                          <!-- end shop item -->
                        @endforeach
                      </div>
                      <!-- end related products slider -->
                  </div>
                  {{-- related product --}}
                  {{-- related product --}}
              </div>

              <!-- sidebar  -->
              <div class="col-sm-3 col-sm-pull-9 sidebar">
                  
                  <!-- category and subcategory widget  -->
                  @include('partials/shop-sidebar')
                  <!-- category and subcategory widget  -->

                  <!-- new arrival widget  -->
                  <div class="widget">
                      <h5 class="widget-title font-alt">New Arrivals</h5>
                      <div class="thin-separator-line bg-dark-gray no-margin-lr margin-ten"></div>
                      <div class="widget-body">
                          {{-- <ul class="colors clearfix">
                              <li class="active"><a href="#" style="background:#f16b4e"></a></li>
                              <li><a href="#" style="background:#f69679"></a></li>
                              <li><a href="#" style="background:#fca95e"></a></li>
                              <li><a href="#" style="background:#7bbc72"></a></li>
                              <li><a href="#" style="background:#4fb2ac"></a></li>
                              <li><a href="#" style="background:#5280c5"></a></li>
                              <li><a href="#" style="background:#eb432d"></a></li>
                              <li><a href="#" style="background:#f98a37"></a></li>
                              <li><a href="#" style="background:#51a84c"></a></li>
                              <li><a href="#" style="background:#008273"></a></li>
                              <li><a href="#" style="background:#009fec"></a></li>
                              <li><a href="#" style="background:#f3690f"></a></li>

                          </ul> --}}
                      </div>
                  </div>                  
                  <!-- end widget  -->
              </div>
              <!-- end sidebar  -->
          </div>
      </div>
  </section>
  <!-- end content section -->
@endsection

@section('js')
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