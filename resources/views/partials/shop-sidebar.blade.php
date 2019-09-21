<!-- widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">ক্যাটাগরি</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr margin-ten"></div>
    <div class="widget-body">
        <ul class="category-list">
        	@foreach($categories as $category)
        	<li><a href="{{ route('product.categorywise', [$category->id, generate_token(100)]) }}">{{ $category->name }}<span>{{ $category->products->count() }}</span></a></li>
        	@endforeach
            {{-- <li class="active"><a href="#">Dresses<span>48</span></a></li> --}}
        </ul>
    </div>
</div>
<!-- end widget  -->