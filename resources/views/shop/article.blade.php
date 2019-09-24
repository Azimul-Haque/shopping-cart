@extends('layouts.index')

@section('title', $article->title)

@section('css')
  @if($article->image != null)
      <meta property="og:image" content="{{ asset('images/pages/'.$article->image) }}" />
  @else
      <meta property="og:image" content="{{ asset('images/abc.png') }}" />
  @endif

  <meta property="og:title" content="{{ $article->title }} | page"/>
  <meta name="description" property="og:description" content="{{ substr(strip_tags($article->description), 0, 200) }}" />
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{ Request::url() }}" />
  <meta property="og:site_name" content="Ecomm Name">
  <meta property="og:locale" content="en_US">
  <meta property="fb:admins" content="100001596964477">
  <meta property="fb:app_id" content="163879201229487">
  <meta property="og:type" content="article">
  <!-- Open Graph - Article -->
  <meta name="article:section" content="Ecoomerce Name">
  <meta name="article:published_time" content="{{ $article->created_at}}">
  <meta name="article:author" content="Ecom">
  <meta name="article:tag" content="Article">
  <meta name="article:modified_time" content="{{ $article->updated_at}}">
@endsection

@section('content')
  <!-- product section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <!-- section title -->
              <div class="col-md-6 col-sm-6">
                  <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">{{ $article->title }}</span>
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
                  <!-- post title  -->
                  <h2 class="blog-details-headline text-black">{{ $article->title }}</h2>
                  <!-- end post title  -->
                  <!-- post date and categories  -->
                  <div class="blog-date no-padding-top">{{ date('F d, Y', strtotime($article->created_at)) }}</div>
                  <!-- end date and categories   -->
                  <!-- post image -->
                  <div class="blog-image margin-eight"><img src="{{ asset('images/pages/' . $article->image) }}" alt="" ></div>
                  <!-- end post image -->
                  <!-- post details text -->
                  <div class="blog-details-text border-bottom">
                      {!! $article->description !!}
                  </div>
                  <!-- end post details text -->
                  
                  <!-- social icon -->
                  <div class="text-center border-bottom margin-ten padding-four no-margin-top">
                      <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-facebook"></i></a>
                      <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-twitter"></i></a>
                      <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url()}}&title=IIT%20Alumni%20Association&summary={{ $article->title }}&source=Killa%20Consultancy" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-linkedin"></i></a>
                  </div>
                  <!-- end social icon -->

                  {{-- related product --}}
                  {{-- related product --}}
                  <div class="row padding-top-ten">
                      <div class="col-md-12 text-center">
                          <h3 class="section-title">New Arrivals</h3>
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