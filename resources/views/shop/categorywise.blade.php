@extends('layouts.index')

@section('title', 'Category wise | LOYAL অভিযাত্রী')

@section('css')
  <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
@endsection

@section('content')
  <!-- product section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
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
          <div class="row">
              <div class="col-sm-9 col-sm-push-3">
                  {{-- <div class="shorting clearfix xs-margin-top-three">
                      <div class="col-md-8 col-sm-7 grid-nav">
                          <a href="shop-with-sidebar-list.html"><i class="fa fa-bars"></i></a>
                          <a href="shop-with-sidebar.html"><i class="fa fa-th"></i></a>
                          <p class="text-uppercase letter-spacing-1 sm-display-none">Showing 1–12 of 22 results</p>
                      </div>
                      <div class="col-md-3 col-sm-5 pull-right">
                          <div class="select-style input-round med-input shop-shorting no-border">
                              <select>
                                  <option value="">Select sort by</option>
                                  <option value="">By popularity</option>
                                  <option value="">By rating</option>
                                  <option value="">Price: low to high</option>
                                  <option value="">Price: high to low</option>
                              </select>
                          </div>
                      </div>
                  </div> --}}
                  <div class="product-listing margin-three">
                      @foreach($products as $product)
                      <!-- shop item -->
                      <div class="col-md-6 col-sm-6">
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
                      @endforeach
                  </div>
                  <!-- pagination -->
                  <div class="margin-three">
                    @include('pagination.default', ['paginator' => $products])
                  </div>
                  <hr/>
                  <!-- end pagination -->
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