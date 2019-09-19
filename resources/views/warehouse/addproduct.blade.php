@extends('partials.warehousepartials')

@section('title', 'পণ্য যোগ | ইকমার্স')

@section('warehousecontent')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          নতুন পণ্য যোগ করুন
        </div>
        <div class="panel-body">
          @if(Request::is('warehouse/addproduct')) 
          {!! Form::open(['route' => 'warehouse.addproduct', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
          @elseif(Request::is('warehouse/editproduct/*'))
          {!! Form::model($product, ['route' => ['warehouse.editproduct', $product->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
          @endif
          
            {!! Form::label('title', 'পণ্যের নাম') !!}
            {!! Form::text('title', null, array('class' => 'form-control', 'required' => '')) !!}

            {!! Form::label('description', 'বিবরণ') !!}
            {!! Form::text('description', null, array('class' => 'form-control')) !!}

            {!! Form::label('oldprice', 'আগের মূল্য (এরকম দেখানোর জন্যঃ <strike>৳৯৯</strike>, ঐচ্ছিক)', [], false) !!}
            {!! Form::text('oldprice', null, array('class' => 'form-control')) !!}

            {!! Form::label('price', 'মূল্য') !!}
            {!! Form::text('price', null, array('class' => 'form-control', 'required' => '')) !!}

            {!! Form::label('category', 'পণ্যের শ্রেণিবিভাগ') !!}
            <select class="form-control" name="category_id" required="">
              <option value="" selected="" disabled="">Select Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>

            {{ Form::label('image', 'পণ্যের ছবি (বর্গাকৃতি, ২০০ কিলোবাইটের মধ্যে)', []) }}
            {{ Form::file('image') }}

            {!! Form::submit('পণ্য যোগ করুন', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          পণ্য তালিকা
        </div>
        <div class="panel-body">
          <table class="table table-condenced">
            <thead>
              <tr>
                <th>পণ্য</th>
                <th>পুর্বমূল্য</th>
                <th>মূল্য</th>
                <th>ছবি</th>
                <th>কার্যকলাপ</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
                <tr>
                  <td>{{ $product->title }}</td>
                  <td>৳ <strike>{{ $product->oldprice }}</strike></td>
                  <td>৳ {{ $product->price }}</td>
                  <td><img style="max-height: 40px; border:1px solid #777" class="img-responsive" src="{{ asset('images/product-images/'.$product->imagepath) }}"></td>
                  <td>
                    <a href="{{ route('warehouse.editproduct', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    @if($product->isAvailable == 1)
                    <a type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#makeUnavailable{{ $product->id }}" data-backdrop="static"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    @elseif($product->isAvailable == 0)
                    <a type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#makeUnavailable{{ $product->id }}" data-backdrop="static"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
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
                                  <img style="max-height: 100px; border:1px solid #777" class="img-responsive" src="{{ asset('images/product-images/'.$product->imagepath) }}">
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
                    <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection