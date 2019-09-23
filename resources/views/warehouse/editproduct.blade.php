@extends('adminlte::page')

@section('title', 'Edit Product | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
  <div class="row">
  	<div class="col-md-10 col-md-offset-1">
  		{!! Form::model($product, ['route' => ['warehouse.editproduct', $product->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
  		<div class="modal-content">
  		  <div class="modal-header modal-header-primary">
  		    <h4 class="modal-title">
  		      Edit Product: {{ $product->title }}
  		    </h4>
  		  </div>
  		  <div class="modal-body">
  		    <div class="row">
  		      <div class="col-md-4">
  		        {!! Form::label('title', 'Product Title *') !!}
  		        {!! Form::text('title', null, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-4">
  		        {!! Form::label('shorttext', 'Short Description') !!}
  		        {!! Form::text('shorttext', null, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-4">
  		        {!! Form::label('code', 'Product Code (Optional)') !!}
  		        {!! Form::text('code', null, array('class' => 'form-control')) !!}
  		      </div>
  		    </div>
  		    <div class="row">
  		      <div class="col-md-6">
  		        {!! Form::label('oldprice', 'Old Price (<strike>৳ 120</strike>, Optional)', [], false) !!}
  		        {!! Form::text('oldprice', null, array('class' => 'form-control')) !!}
  		      </div>
  		      <div class="col-md-6">
  		        {!! Form::label('price', 'Price *') !!}
  		        {!! Form::text('price', null, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		    </div>

  		    {!! Form::label('description', 'Description *') !!}
  		    {!! Form::text('description', null, array('class' => 'form-control', 'required' => '')) !!}


  		    <div class="row">
  		      <div class="col-md-6">
  		        {!! Form::label('subcategory_id', 'Sub Category *') !!}
  		        <select class="form-control" name="subcategory_id" required="">
  		          <option value="" selected="" disabled="">Select Sub Category</option>
  		          @foreach($categories as $category)
  		            @foreach($category->subcategories->sortBy('image') as $subcategory)
  		              <option value="{{ $subcategory->id }}" @if($product->subcategory_id == $subcategory->id) selected="" @endif>{{ $subcategory->name }}</option>
  		            @endforeach
  		          @endforeach
  		        </select>
  		      </div>
  		      <div class="col-md-6">
  		        {!! Form::label('stock', 'Stock (Optional)') !!}
  		        {!! Form::text('stock', null, array('class' => 'form-control')) !!}
  		      </div>
  		    </div>
  		    <hr/>

  		    <div class="row">
  		      <div class="col-md-12">
  		        <big><b>If no image is selected, these will be used, Size: 400KB Max, height x width : 600px x 500px (Applied for all images)</b></big><br/>
		        @foreach($product->productimages as $image)
		          <img style="max-height: 100px; border:1px solid #777; float: left; margin-right: 10px;" class="img-responsive" src="{{ asset('images/product-images/'.$image->image) }}">
		        @endforeach
  		      </div>
  		    </div>
  		    
  		    <div class="row">
  		      <div class="col-md-4">
  		        {{ Form::label('image1', 'Image 1') }}
  		        <input type="file" id="image1" name="image1">
  		      </div>
  		      <div class="col-md-4">
  		        {{ Form::label('image2', 'Image 2') }}
  		        <input type="file" id="image2" name="image2">
  		      </div>
  		      <div class="col-md-4">
  		        {{ Form::label('image3', 'Image 3') }}
  		        <input type="file" id="image3" name="image3">
  		      </div>
  		      <div class="col-md-4">
  		        {{ Form::label('image4', 'Image 4') }}
  		        <input type="file" id="image4" name="image4">
  		      </div>
  		      <div class="col-md-4">
  		        {{ Form::label('image5', 'Image 5') }}
  		        <input type="file" id="image5" name="image5">
  		      </div>
  		    </div>
  		    <hr/>
  		    
  		    <div class="row">
  		      <div class="col-md-3">
  		        {!! Form::label('buying_price', 'Buying Price *') !!}
  		        {!! Form::text('buying_price', null, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-3">
  		        {!! Form::label('carrying_cost', 'Carrying Cost (%) *') !!}
  		        {!! Form::text('carrying_cost', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-3">
  		        {!! Form::label('vat', 'Vat (%) *') !!}
  		        {!! Form::text('vat', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-3">
  		        {!! Form::label('salary', 'Salary (%) *') !!}
  		        {!! Form::text('salary', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		    </div>
  		    <div class="row">
  		      <div class="col-md-3">
  		        {!! Form::label('wages', 'Wages (%) *') !!}
  		        {!! Form::text('wages', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-3">
  		        {!! Form::label('utility', 'Utility (%) *') !!}
  		        {!! Form::text('utility', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		      <div class="col-md-3">
  		        {!! Form::label('others', 'Others (%) *') !!}
  		        {!! Form::text('others', 0, array('class' => 'form-control', 'required' => '')) !!}
  		      </div>
  		    </div>
  		  </div>
  		  <div class="modal-footer">
  		  	<button type="submit" class="btn btn-primary">Update</button>
  		  </div>
  		</div>
  		{!! Form::close() !!}
  	</div>
  </div>
@endsection

@section('js')
    
@stop