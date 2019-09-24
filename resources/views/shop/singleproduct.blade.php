@extends('layouts.index')

@section('title', 'ইকমার্স')

@section('css')
  <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
  <style type="text/css">
    .padding-top-ten {
      padding-top: 10%;
    }
    .padding-top-five {
      padding-top: 5%;
      padding-bottom: 5%;
    }
    .image-thumb-product {
      max-height: 50px; 
      width: auto; 
      border: 1px solid gray;
    }
  </style>
  <meta property="og:image" content="{{ asset('images/product-images/'.$product->productimages->first()->image) }}" />
  <meta property="og:title" content="{{ $product->title }} | Ecoomerce Name"/>
  <meta name="description" property="og:description" content="{{ substr(strip_tags($product->description), 0, 200) }}" />
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{ Request::url() }}" />
  <meta property="og:site_name" content="Ecomm Name">
  <meta property="og:locale" content="en_US">
  <meta property="fb:admins" content="100001596964477">
  <meta property="fb:app_id" content="163879201229487">
  <meta property="og:type" content="article">
  <!-- Open Graph - Article -->
  <meta name="article:section" content="Ecoomerce Name">
  <meta name="article:published_time" content="{{ $product->created_at}}">
  <meta name="article:author" content="Ecom">
  <meta name="article:tag" content="Product">
  <meta name="article:modified_time" content="{{ $product->updated_at}}">
@endsection

@section('content')
  <!-- product section -->
  <section class="content-top-margin page-title page-title-small bg-gray">
      <div class="container">
          <div class="row">
              <!-- section title -->
              <div class="col-md-12 col-sm-12">
                  <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">Product | {{ $product->title }}</span>
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
                <div class="row margin-five">
                    <!-- product images -->
                    <div class="col-md-6 col-sm-12 zoom-gallery sm-margin-bottom-ten">
                        <a href="{{ asset('images/product-images/' . $product->productimages->first()->image) }}"><img src="{{ asset('images/product-images/' . $product->productimages->first()->image) }}" alt=""/></a>
                        <div class=" text-center">
                          @foreach($product->productimages as $image)
                            <a href="{{ asset('images/product-images/' . $image->image) }}"><img class="image-thumb-product" src="{{ asset('images/product-images/' . $image->image) }}" alt="" /></a>
                          @endforeach
                        </div>
                    </div>
                    <!-- end product images -->
                    <div class="col-md-5 col-sm-12 col-md-offset-1">
                        <!-- product rating -->
                        <div class="rating margin-five no-margin-top">
                            <i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star-o black-text"></i><span class="rating-text text-uppercase">0 Reviews</span>
                            <span class="rating-text text-uppercase pull-right">
                              SKU: 
                              @if($product->code != '')
                                <span class="black-text">{{ $product->code }}</span>
                              @else
                                N/A
                              @endif
                            </span>
                        </div>
                        <!-- end product rating -->
                        <!-- product name -->
                        <span class="product-name-details text-uppercase font-weight-600 letter-spacing-2 black-text">{{ $product->title }}</span>
                        <!-- end product name -->
                        <!-- product stock -->
                        <p class="text-uppercase letter-spacing-2 margin-two">
                          @if($product->isAvailable == 1)
                            In Stock / Shipping Available
                          @else
                            Out of Stock / Shipping Unavailable
                          @endif
                        </p>
                        <!-- end product stock -->
                        <div class="separator-line bg-black no-margin-lr margin-five"></div>
                        <!-- product short description -->
                        <p>{{ $product->shorttext }}</p>
                        <!-- end product short description -->
                        <span class="price black-text title-small">
                          @if($product->oldprice > 0)
                            <del>৳ {{ $product->oldprice }}</del>
                          @endif
                          ৳ {{ $product->price }}
                        </span>
                        <div class="col-md-3 col-sm-3 no-padding-left margin-five">
                            <div class="select-style med-input xs-med-input shop-shorting-details no-border-round">
                                <!-- product qty -->
                                <select id="productQty">
                                    <option value="" disabled="">Qty</option>
                                    <option value="1" selected="">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <!-- end product qty -->
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 no-padding margin-five">
                            <!-- add to bag button -->
                            <button class="highlight-button-dark btn btn-medium button" id="addToCartSingle"><i class="icon-basket"></i> Add To Cart</button>
                            <!-- end add to bag button -->
                        </div>
                        <div class="col-md-6 no-padding-left">
                            <!-- add to wishlist link -->
                            <a title="Add to Wishlist" href="#!" class="text-uppercase text-small vertical-align-middle"><i class="fa fa-heart-o black-text"></i> Add to wishlist</a>
                            <!-- end add to wishlist link -->
                        </div>
                        <div class="col-md-6 product-details-social no-padding">
                            <!-- social media sharing -->
                            <span class="black-text text-uppercase text-small vertical-align-middle margin-right-five">Share</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url()}}&title=IIT%20Alumni%20Association&summary={{ $product->title }}&source=Killa%20Consultancy" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-linkedin"></i></a>
                            <!-- end social media sharing -->
                        </div>
                    </div>
                </div>

                {{-- product detail --}}
                {{-- product detail --}}
                <div class="row border-top padding-top-five">
                    <div class="col-md-12 col-sm-12">
                        <!-- tab -->
                        <div class="tab-style1">
                            <div class="col-md-12 col-sm-12 no-padding">
                                <!-- tab navigation -->
                                <ul class="nav nav-tabs nav-tabs-light text-left">
                                    <li class="active"><a href="#desc_tab" data-toggle="tab">Description</a></li>
                                    <li><a href="#reviews_tab" data-toggle="tab">Reviews (10)</a></li>
                                    <li><a href="#info_tab" data-toggle="tab">Information</a></li>
                                </ul>
                                <!-- tab end navigation -->
                            </div>
                            <!-- tab content section -->
                            <div class="tab-content">
                                <!-- tab content -->
                                <div class="tab-pane med-text fade in active" id="desc_tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>{{ $product->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- tab content -->
                                <div class="tab-pane fade in" id="info_tab">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <ul class="instructions">
                                                <li><strong>Weight:</strong> 7.25 Kg</li>
                                                <li><strong>Dimensions:</strong> 90x60x90 Cm</li>
                                                <li><strong>Size:</strong> One Size Fits All</li>
                                                <li><strong>Color:</strong> White</li>
                                                <li><strong>Guarantee:</strong> 5 Years</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-sm-12 sm-margin-top-seven">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- tab content -->
                                <div class="tab-pane fade in" id="reviews_tab">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 review-main">
                                            <div class="review">
                                                <p class="letter-spacing-2 text-uppercase review-name"><strong>Nathan Ford,</strong> March 15, 2015</p>
                                                <p><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star-o black-text"></i><i class="fa black-text fa-star-o"></i></p>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                                            </div>
                                            <div class="review">
                                                <p class="letter-spacing-2 text-uppercase review-name"><strong>Paul Scrivens,</strong> March 09, 2015</p>
                                                <p><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa fa-star black-text"></i><i class="fa black-text fa-star-o"></i></p>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            </div>
                                            <ul class="list-inline comment-pagination">
                                                <li><a href="#" class="active">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">...</a></li>
                                                <li><a href="#">8</a></li>
                                                <li><a href="#">9</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-md-offset-1 blog-single-full-width-form sm-margin-top-seven">
                                            <div class="blog-comment-form">
                                                <!-- comment form -->
                                                <form>
                                                    <!-- input -->
                                                    <input type="text" name="name" placeholder="Name">
                                                    <!-- end input -->
                                                    <!-- input  -->
                                                    <input type="text" name="email" placeholder="Email">
                                                    <!-- end input -->
                                                    <!-- input  -->
                                                    <label class="rating">Rating</label>
                                                    <p class="add-rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></p>
                                                    <!-- end input -->
                                                    <!-- textarea  -->
                                                    <textarea name="comment" placeholder="Comment"></textarea>
                                                    <!-- end textarea  -->
                                                    <!-- button  -->
                                                    <input type="submit" name="send message" value="LEAVE RATING" class="highlight-button-black-border btn btn-small xs-no-margin-bottom">
                                                    <!-- end button  -->
                                                </form>
                                                <!-- end comment form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                            </div>
                            <!-- end tab content section -->
                        </div>
                        <!-- end tab -->
                    </div>
                </div>
                {{-- product detail --}}
                {{-- product detail --}}

                {{-- related product --}}
                {{-- related product --}}
                <div class="row border-top padding-top-ten">
                    <div class="col-md-12 text-center">
                        <h3 class="section-title">Related Products</h3>
                    </div>
                </div>
                <div class="row">
                    <!-- related products slider -->
                    <div id="shop-products" class="owl-carousel owl-theme dark-pagination owl-no-pagination owl-prev-next-simple">
                      @foreach($relatedproducts as $relproduct)
                        <!-- shop item -->
                        <div class="item">
                            <div class="home-product text-center position-relative overflow-hidden">
                                <a href="{{ route('product.getsingleproduct', [$relproduct->id, generate_token(100)]) }}"><img src="{{ asset('images/product-images/'.$relproduct->productimages->first()->image) }}" alt=""/></a>
                                <span class="product-name text-uppercase"><a href="{{ route('product.getsingleproduct', [$relproduct->id, generate_token(100)]) }}">{{ $relproduct->title }}</a></span>
                                <span class="price black-text">
                                  @if($relproduct->oldprice)
                                  <del>৳ {{ $relproduct->oldprice }}</del>
                                  @endif
                                  ৳ {{ $relproduct->price }}
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
                <hr/>
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
  $(document).ready(function(){
      $("#addToCartSingle").click(function(){
        console.log('Qty: '+$('#productQty').val());
        console.log('Item ID: {{ $product->id }}');
        $.ajax({
            url: "/addtocartsingle/{{ $product->id }}/" + $('#productQty').val(),
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
              totalInBag = totalInBag + parseInt($('#productQty').val());
              $("#totalInBag").text(totalInBag);
              
              var totalInBagMobile = parseInt($("#totalInBagMobile").text());
              if(isNaN(totalInBagMobile)) {
                totalInBagMobile = 0;
              } else {
                totalInBagMobile = totalInBagMobile;
              }
              totalInBagMobile = totalInBagMobile + parseInt($('#productQty').val());
              $("#totalInBagMobile").text(totalInBagMobile);
            }
        });
      });
  });
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