@extends('layouts.master')

@section('title', 'বাজারের ব্যাগ | ইকমার্স')

@section('content')
  <div class="row">
    {{-- <div class="col-md-2">
      @include('partials/shop-sidebar')
    </div> --}}
    <div class="col-md-8 col-md-offset-2">
      @if(Session::has('cart'))
        <div class="">
          <h2>আপনার অর্ডারগুলো</h2>
          <ul class="list-group">
            @foreach($products as $product)
              <li class="list-group-item" id="productItemListItem{{ $product['item']['id'] }}">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <strong>{{ $product['item']['title'] }}</strong> / 
                    <span class="label label-success">৳ {{ $product['item']['price'] }}</span>
                    <img src="{{ asset('images/product-images/'.$product['item']['imagepath']) }}" style="max-height: 40px; border:1px solid #777">
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="row">
                      <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12 item-center">
                        <div class="btn-group">
                          <button id="reducebyone{{ $product['item']['id'] }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="আইটেমটির পরিমাণ হ্রাস করুন"><i class="fa fa-minus" aria-hidden="true"></i></button>
                          <a id="itemQtyInBag{{ $product['item']['id'] }}" class="btn btn-primary btn-sm disabled"><span>{{ $product['qty'] }}</span></a>
                          <button id="addbyone{{ $product['item']['id'] }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="আইটেমটির পরিমাণ বৃদ্ধি করুন"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 item-center">
                        <span id="itemTotalPrice{{ $product['item']['id'] }}" class="">মোটঃ ৳ {{ $product['price'] }}</span>
                      </div>
                      <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 item-center">
                        <a class="btn btn-link btn-sm" class="right" href="{{ route('product.removeitem', ['id' => $product['item']['id']]) }}" data-toggle="tooltip" data-placement="bottom" title="এই আইটেমটি তালিকা থেকে বাদ দিতে হলে এখানে ক্লিক করুন"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <script type="text/javascript">
                $(document).ready(function(){
                    $("#reducebyone{{ $product['item']['id'] }}").click(function(){
                      console.log('Item ID: ' + {{ $product['item']['id'] }});
                      $.ajax({
                          url: "/reduce/{{ $product['item']['id'] }}",
                          type: "GET",
                          data: {},
                          success: function (data) {
                            var response = data;
                            console.log(response);
                            if(response == 'success') {
                              toastr.success('{{ $product['item']['title'] }} এর এক ইউনিট পরিমাণ আপনার ব্যাগ থেকে বাদ দেওয়া হয়েছে।', 'সফল (SUCCESS)').css('width','400px');
                            }
                            var totalInBag = parseInt($("#totalInBag").text()) - 1;
                            var totalInBagMobile = parseInt($("#totalInBagMobile").text()) - 1;
                            $("#totalInBag").text(totalInBag);
                            $("#totalInBagMobile").text(totalInBag);
                            var itemQtyInBag = parseInt($("#itemQtyInBag{{ $product['item']['id'] }}").text()) - 1;
                            $("#itemQtyInBag{{ $product['item']['id'] }}").text(itemQtyInBag);
                            if(itemQtyInBag == 0) {
                              $("#productItemListItem{{ $product['item']['id'] }}").fadeOut("slow");
                            }
                            var itemTotalPrice = $("#itemTotalPrice{{ $product['item']['id'] }}").text();
                            itemTotalPrice = parseInt(itemTotalPrice.replace("মোটঃ ৳ ", "")) - {{ $product['item']['price'] }};
                            itemTotalPrice = "মোটঃ ৳ " + itemTotalPrice;
                            $("#itemTotalPrice{{ $product['item']['id'] }}").text(itemTotalPrice);

                            var totalPriceGross = $("#totalPriceGross").text();
                            totalPriceGross = parseInt(totalPriceGross.replace("মোট মূল্যঃ ৳ ", "")) - {{ $product['item']['price'] }};
                            totalPriceGross = "মোট মূল্যঃ ৳ " + totalPriceGross;
                            $("#totalPriceGross").text(totalPriceGross);
                          }
                      });
                    });
                    $("#addbyone{{ $product['item']['id'] }}").click(function(){
                      console.log('Item ID: ' + {{ $product['item']['id'] }});
                      $.ajax({
                          url: "/add/{{ $product['item']['id'] }}",
                          type: "GET",
                          data: {},
                          success: function (data) {
                            var response = data;
                            console.log(response);
                            if(response == 'success') {
                              toastr.success('{{ $product['item']['title'] }} এর এক ইউনিট পরিমাণ আপনার ব্যাগে যোগ করা হয়েছে।', 'সফল (SUCCESS)').css('width','400px');
                            }
                            var totalInBag = parseInt($("#totalInBag").text()) + 1;
                            var totalInBagMobile = parseInt($("#totalInBagMobile").text()) + 1;
                            $("#totalInBag").text(totalInBag);
                            $("#totalInBagMobile").text(totalInBag);
                            var itemQtyInBag = parseInt($("#itemQtyInBag{{ $product['item']['id'] }}").text()) + 1;
                            $("#itemQtyInBag{{ $product['item']['id'] }}").text(itemQtyInBag);
                            var itemTotalPrice = $("#itemTotalPrice{{ $product['item']['id'] }}").text();
                            itemTotalPrice = parseInt(itemTotalPrice.replace("মোটঃ ৳ ", "")) + {{ $product['item']['price'] }};
                            itemTotalPrice = "মোটঃ ৳ " + itemTotalPrice;
                            $("#itemTotalPrice{{ $product['item']['id'] }}").text(itemTotalPrice);

                            var totalPriceGross = $("#totalPriceGross").text();
                            totalPriceGross = parseInt(totalPriceGross.replace("মোট মূল্যঃ ৳ ", "")) + {{ $product['item']['price'] }};
                            totalPriceGross = "মোট মূল্যঃ ৳ " + totalPriceGross;
                            $("#totalPriceGross").text(totalPriceGross);
                          }
                      });
                    });
                });
              </script>
            @endforeach
          </ul>
        </div>
        <div class="">
          <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-2">
              <strong style="float: right;" id="totalPriceGross">মোট মূল্যঃ ৳ {{ $totalPrice }}</strong>
            </div>
            <div class="col-md-2">
            </div>
          </div>
          <hr/>
        </div>
        <div class="">
          <a href="{{ route('product.checkout') }}" class="btn btn-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> অর্ডারটি নিশ্চিত করুন</a>
        </div>
      @else
        <div class="col-md-10 col-md-offset-1">
          <h3>
            আপনার বাজারের ব্যাগে কোন পণ্য নেই! আমাদের পণ্যগুলো ব্যাগে যোগ করে এই পেইজে আসুন। ধন্যবাদ।<br/><br/>
            <center><a href="{{ route('product.index') }}"><i class="fa fa-cart-plus"></i> পণ্য দেখুন</a></center>
          </h3>

        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>
@endsection