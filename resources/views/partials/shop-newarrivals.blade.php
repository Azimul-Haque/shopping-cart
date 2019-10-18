<!-- new arrival widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">New Arrivals</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr margin-ten"></div>
    <div class="widget-body">
        <ul class="widget-posts">
          @foreach($newarrivals as $product)
            <li class="clearfix">
                <a href="{{ route('product.getsingleproduct', [$product->id, generate_token(100)]) }}">
                  <img src="{{ asset('images/product-images/'.$product->productimages->first()->image) }}" alt="{{ $product->title }}">
                </a>
                <div class="widget-posts-details">
                  <a href="{{ route('product.getsingleproduct', [$product->id, generate_token(100)]) }}">
                    {{ $product->title }}
                  </a> 
                  @if($product->oldprice > 0)
                    <del>৳ {{ $product->oldprice }}</del>
                  @endif
                  ৳ {{ $product->price }}
                </div>
            </li>
          @endforeach
        </ul>
    </div>
</div>                  
<!-- end widget  -->