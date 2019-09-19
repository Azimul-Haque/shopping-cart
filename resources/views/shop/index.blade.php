@extends('layouts.master')

@section('title', 'ইকমার্স')

@section('content')
  <div class="row">
    <div class="col-md-2">
      @include('partials/shop-sidebar')
    </div>
    <div id="col-md-10" class="col-md-10">
      <div id="searched_list">
      </div>
      <div id="products_list">
      <style type="text/css">
        @media (min-width: 1200px) {
            .col-lg-5ths {
                width: 20% !important;
                *width: 20% !important;
                float: left;
            }
        }
      </style>
      @foreach($products as $product)
      <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-lg-5ths" id="">
        <div class="thumbnail">
          <img src="{{ asset('images/product-images/'.$product->imagepath) }}" alt="{{ $product->title }}" class="img-responsive product-thumbnail">
          <div class="caption">
            <h4>{{ $product->title }}</h4>
            <p class="text-muted">{{ $product->description }}</p> {{-- class="description" --}}
            <div class="clearfix">
              <div class="price">
                ৳ {{ $product->price }}
                <small class="oldprice">৳ <strike>{{ $product->oldprice }}</strike></small>
              </div>
              <button id="addToCart{{ $product->id }}" class="btn btn-success btn-block btn-sm" role="button"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ব্যাগে যোগ করুন</button>
            </div>
          </div>
        </div>
      </div>
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
                      toastr.success('{{ $product->title }} আপনার ব্যাগে যুক্ত করা হয়েছে।', 'সফল (SUCCESS)').css('width','400px');
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
      <br/>
      {{-- {{ $products->links() }} --}}
      </div>
    </div>
  </div>
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

@section('script')


@endsection