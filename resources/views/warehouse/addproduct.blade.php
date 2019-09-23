@extends('adminlte::page')

@section('title', 'Products | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>Products
      @if(Request::is('warehouse/edit/product/*'))
        {{ $product->title }}
      @endif
      <div class="pull-right">
        @if(Request::is('warehouse/edit/product/*'))
          <a href="{{ route('warehouse.addproduct') }}" class="btn btn-sm btn-primary" title="Back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
        @else
          <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#addAndEditProduct" data-backdrop="static" title="Add New Product"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>
        @endif
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Product List
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condenced">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Image</th>
                  <th>Buying Price</th>
                  <th>Carrying Cost (%)</th>
                  <th>Vat (%)</th>
                  <th>Salary (%)</th>
                  <th>Wages (%)</th>
                  <th>Utility (%)</th>
                  <th>Others (%)</th>
                  <th>Total Cost</th>
                  <th>Selling Price</th>
                  <th>Profit</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                  <tr>
                    <td>
                      {{ $product->title }}<br/>
                      <small>{{ $product->category->name }} - {{ $product->subcategory->name }}</small>
                    </td>
                    <td>
                      <img style="max-height: 40px; border:1px solid #777" class="img-responsive" src="{{ asset('images/product-images/'.$product->productimages->first()->image) }}">
                    </td>
                    <td>৳ {{ $product->buying_price }}</td>
                    <td>{{ $product->carrying_cost}}%</td>
                    <td>{{ $product->vat }}%</td>
                    <td>{{ $product->salary }}%</td>
                    <td>{{ $product->wages }}%</td>
                    <td>{{ $product->utility }}%</td>
                    <td>{{ $product->others }}%</td>
                    <td>
                      @php
                        $total_cost = $product->buying_price + (($product->buying_price*$product->carrying_cost)/100) + (($product->buying_price*$product->vat)/100) + (($product->buying_price*$product->salary)/100) + (($product->buying_price*$product->wages)/100) + (($product->buying_price*$product->utility)/100) + (($product->buying_price*$product->others)/100);
                      @endphp
                      ৳ {{ $total_cost }}
                    </td>
                    <td>
                      ৳ {{ $product->price }}<br/>
                      @if($product->oldprice > 0)
                        ৳ <strike>{{ $product->oldprice }}</strike>
                      @endif
                    </td>
                    <td>৳ {{ $product->price - $total_cost }}</td>
                    <td>
                      <a href="{{ route('warehouse.geteditproduct', [$product->id, generate_token(100)]) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      @if($product->isAvailable == 1)
                      <a type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#makeUnavailable{{ $product->id }}" data-backdrop="static" title="Make this product unavailable"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      @elseif($product->isAvailable == 0)
                      <a type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#makeUnavailable{{ $product->id }}" data-backdrop="static" title="Make this product available"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      @endif
                      <!-- Modal -->
                      <div class="modal fade" id="makeUnavailable{{ $product->id }}" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header modal-header-warning">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">আপনি কি নিশ্চিতভাবে এই পণ্যটিকে 
                              @if($product->isAvailable == 1)
                              অপ্রাপ্য
                              @elseif($product->isAvailable == 0)
                              প্রাপ্য
                              @endif
                            করতে চান?</h4>
                            </div>
                            <div class="modal-body">
                              <p>
                                <center>
                                  <h2>{{ $product->title }}</h2>
                                  <h4>{{ $product->category->name }}</h4>
                                  মূল্যঃ ৳ {{ $product->price }}<br/><br/>
                                  <img style="max-height: 100px; border:1px solid #777" class="img-responsive" src="{{ asset('images/product-images/'.$product->productimages->first()->image) }}">
                                </center>
                              </p>
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($product, ['route' => ['warehouse.unavailableproduct', $product->id], 'method' => 'PUT']) !!}
                                @if($product->isAvailable == 1)
                                <button type="submit" class="btn btn-danger">অপ্রাপ্য করুন</button>
                                @elseif($product->isAvailable == 0)
                                <button type="submit" class="btn btn-success">প্রাপ্য করুন</button>
                                @endif
                                <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> --}}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>

  {{-- add product modal --}}
  <div class="modal fade" id="addAndEditProduct" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      @if(Request::is('warehouse/addproduct')) 
      {!! Form::open(['route' => 'warehouse.addproduct', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
      @elseif(Request::is('warehouse/edit/product/*'))
      {!! Form::model($product, ['route' => ['warehouse.editproduct', $product->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
      @endif
      
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close noPrint" data-dismiss="modal">×</button>
          <h4 class="modal-title">
            @if(Request::is('warehouse/edit/product/*'))
              Edit Product {{ $product->title }}
            @else
              Add Product
            @endif
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
                  @foreach($category->subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
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
              @if(Request::is('warehouse/edit/product/*'))
                <big><b>If no image is selected, these will be used, Size: 400KB Max, height x width : 600px x 500px (Applied for all images)</b></big><br/>
                @foreach($product->productimages as $image)
                <img style="max-height: 100px; border:1px solid #777; float: left; margin-right: 10px;" class="img-responsive" src="{{ asset('images/product-images/'.$image->image) }}">
                @endforeach
              @else
                <big><b>Image 1 is required, Size: 400KB Max, height x width : 600px x 500px (Applied for all images)</b></big>
              @endif
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-4">
              @if(Request::is('warehouse/edit/product/*'))
                {{ Form::label('image1', 'Image 1') }}
                <input type="file" id="image1" name="image1">
              @else
                {{ Form::label('image1', 'Image 1 *') }}
                <input type="file" id="image1" name="image1" required="">
              @endif
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
          @if(Request::is('warehouse/edit/product/*'))
            <button type="submit" class="btn btn-primary">Update</button>
          @else
            <button type="submit" class="btn btn-primary">Submit</button>
          @endif
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('js')
<script type="text/javascript">
  @if(Request::is('warehouse/edit/product/*'))
    $('#addAndEditProduct').modal('show');
  @endif
</script>
@stop