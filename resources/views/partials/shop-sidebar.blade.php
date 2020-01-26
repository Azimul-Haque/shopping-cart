<style type="text/css">
    .subcategory-list {
        margin-left: 40px;
    }
</style>
<!-- widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">Categories & Subcategories</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr margin-ten"></div>
    <div class="widget-body">
        <ul class="category-list">
        	@foreach($categories as $category)
        	   @if($category->products->count() > 0)
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
                        <li>
                            <a href="{{ route('product.categorywise', [$category->id, generate_token(100)]) }}">
                                {{ $category->name }}<span>{{ $category->products->count() }}</span>
                            </a>
                            <ul class="subcategory-list">
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
                                        <li
                                        @if(!empty($subcategoryid))
                                            @if($subcategoryid == $subcategory->id)
                                            class="active"
                                            @endif
                                        @endif
                                        >
                                            <a href="{{ route('product.subcategorywise', [$subcategory->id, generate_token(100)]) }}">
                                                {{ $subcategory->name }}<span>{{ $totalproductofthissubcat }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
               @endif
        	@endforeach
            {{-- <li class="active"><a href="#">Dresses<span>48</span></a></li> --}}
        </ul>
    </div>
</div>
<!-- end widget  -->