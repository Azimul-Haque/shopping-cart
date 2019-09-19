<div class="row">
  <div class="btn-group-vertical col-md-12" role="group" aria-label="...">
    <button type="button" class="btn btn-success btn-block">ক্যাটাগরি অনুযায়ী খুঁজুন</button>
    <a href="{{ route('product.index') }}" class="btn btn-default btn-block">সব</a>
    @foreach($categories as $category)
    	
    	<a href="{{ route('product.categorywise', [$category->id, generate_token(100)]) }}" class="btn btn-default btn-block">{{ $category->name }}</a>
    @endforeach
  </div>
</div>