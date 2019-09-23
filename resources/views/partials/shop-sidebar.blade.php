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
        	<li>
                <a href="{{ route('product.categorywise', [$category->id, generate_token(100)]) }}">
                    {{ $category->name }}<span>{{ $category->products->count() }}</span>
                </a>
                @foreach($category->subcategories as $subcategory)
                    <ul class="subcategory-list">
                        <li
                        @if(!empty($subcategoryid))
                            @if($subcategoryid == $subcategory->id)
                            class="active"
                            @endif
                        @endif
                        >
                            <a href="{{ route('product.subcategorywise', [$subcategory->id, generate_token(100)]) }}">
                                {{ $subcategory->name }}<span>{{ $subcategory->products->count() }}</span>
                            </a>
                        </li>
                    </ul>
                @endforeach
                
            </li>
        	@endforeach
            {{-- <li class="active"><a href="#">Dresses<span>48</span></a></li> --}}
        </ul>
    </div>
</div>
<!-- end widget  -->