@extends('adminlte::page')

@section('title', 'Categories & Subcategories | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Categories & Subcategories</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-success">
        <div class="panel-heading">
          Categories <span class="badge">{{ $categories->count() }}
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th width="30%">নাম</th>
                <th>Subcategories</th>
                <th width="20%">Action</th>
              </tr>
            </thead>

            <tbody>
            @foreach ($categories as $category)
              {!! Form::model($category, ['route' => ['warehouse.categories.update', $category->id], 'method' => 'PUT']) !!}
              <tr>
                <td>
                  <span id="catname{{ $category->id }}">{{ $category->name }}</span>
                  <input type="text" name="name" value="{{ $category->name }}" class="form-control" id="catnameinput{{ $category->id }}" style="display: none;">
                </td>
                <td>
                  @foreach ($category->subcategories as $subcategory)
                    <span class="label label-primary">{{ $subcategory->name }}</span>
                  @endforeach
                </td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" title="Edit" onclick="showUpdateCategory({{ $category->id }})" id="showBtn{{ $category->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                  <button class="btn btn-sm btn-success" title="Update" id="updateBtn{{ $category->id }}" style="display: none; float: left; margin-right: 5px;"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-sm btn-danger" title="Cancel" onclick="hideUpdateCategory({{ $category->id }})" id="cancelBtn{{ $category->id }}" style="display: none; float: left;"><i class="fa fa-times" aria-hidden="true"></i></button>
                </td>
              </tr>
              {!! Form::close() !!}
            @endforeach
            </tbody>

          </table>
        </div>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">
          Subcategories <span class="badge">{{ $subcategories->count() }}
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>নাম</th>
                <th>Category</th>
                <th width="20%">Action</th>
              </tr>
            </thead>

            <tbody>
            @foreach ($subcategories as $subcategory)
              {!! Form::model($subcategory, ['route' => ['warehouse.subcategories.update', $subcategory->id], 'method' => 'PUT']) !!}
              <tr>
                <td>
                  <span id="subcatname{{ $subcategory->id }}">{{ $subcategory->name }}</span>
                  <input type="text" name="name" value="{{ $subcategory->name }}" class="form-control" id="subcatnameinput{{ $subcategory->id }}" style="display: none;">
                </td>
                <td><span class="label label-primary">{{ $subcategory->category->name }}</span></td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" title="Edit" onclick="showUpdateSubcategory({{ $subcategory->id }})" id="showSBtn{{ $subcategory->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                  <button class="btn btn-sm btn-success" title="Update" id="updateSBtn{{ $subcategory->id }}" style="display: none; float: left; margin-right: 5px;"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-sm btn-danger" title="Cancel" onclick="hideUpdateSubcategory({{ $subcategory->id }})" id="cancelSBtn{{ $subcategory->id }}" style="display: none; float: left;"><i class="fa fa-times" aria-hidden="true"></i></button>

                  {{-- make unavailable --}}
                  @if($subcategory->isAvailable == 1)
                  <a type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#makeUnavailable{{ $subcategory->id }}" data-backdrop="static" title="Archive"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  @elseif($subcategory->isAvailable == 0)
                  <a type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#makeUnavailable{{ $subcategory->id }}" data-backdrop="static" title="Unrchive"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  @endif
                  <!-- Modal -->
                  <div class="modal fade" id="makeUnavailable{{ $subcategory->id }}" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header modal-header-warning">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h4 class="modal-title">Sure to make this Subcategory
                          @if($subcategory->isAvailable == 1)
                          Archive
                          @elseif($subcategory->isAvailable == 0)
                          Unrchive
                          @endif
                        ?</h4>
                        </div>
                        <div class="modal-body">
                          <p>
                            <big>
                              <center>
                                Confirm 
                                @if($subcategory->isAvailable == 1)
                                Archive
                                @elseif($subcategory->isAvailable == 0)
                                Unrchive
                                @endif
                                <b>{{ $subcategory->name }}</b>?<br/>
                                Associated Products will be unavailable too!
                              </center>
                            </big>
                          </p>
                        </div>
                        <div class="modal-footer">
                          @if($subcategory->isAvailable == 1)
                          <a href="{{ url('warehouse/subcategory/availibility/toggle/' . $subcategory->id) }}" class="btn btn-danger">Archive</a>
                          @elseif($subcategory->isAvailable == 0)
                          <a href="{{ url('warehouse/subcategory/availibility/toggle/' . $subcategory->id) }}" class="btn btn-success">Unrchive</a>
                          @endif
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- make unavailable --}}
                </td>
              </tr>
              {!! Form::close() !!}
            @endforeach
            </tbody>

          </table>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          পণ্যের শ্রেণিবিভাগ যোগ করুণ
        </div>
        <div class="panel-body">
          {!! Form::open(['route' => 'warehouse.categories', 'method' => 'POST']) !!}
            {!! Form::label('name', 'শ্রেণিবিভাগের নাম') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
            {!! Form::submit('পণ্যের শ্রেণিবিভাগ যোগ করুন', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
          {!! Form::close() !!}
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading">
          Add Subcategory
        </div>
        <div class="panel-body">
          {!! Form::open(['route' => 'warehouse.subcategories', 'method' => 'POST']) !!}
            {!! Form::label('name', 'Subcategory Name') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}

            {!! Form::label('category_id', 'Category Name') !!}
            <select name="category_id" class="form-control" required="">
              <option value="" selected="" disabled="">Select Category</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            {!! Form::submit('Add Subcategory', array('class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;')) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">
    function showUpdateCategory(id) {
      $('#catname' + id).css('display','none');
      $('#showBtn' + id).css('display','none');
      $('#catnameinput' + id).css('display','block');
      $('#updateBtn' + id).css('display','block');
      $('#cancelBtn' + id).css('display','block');
    }
    function hideUpdateCategory(id) {
      $('#catname' + id).css('display','block');
      $('#showBtn' + id).css('display','block');
      $('#catnameinput' + id).css('display','none');
      $('#updateBtn' + id).css('display','none');
      $('#cancelBtn' + id).css('display','none');
    }
    function showUpdateSubcategory(id) {
      $('#subcatname' + id).css('display','none');
      $('#showSBtn' + id).css('display','none');
      $('#subcatnameinput' + id).css('display','block');
      $('#updateSBtn' + id).css('display','block');
      $('#cancelSBtn' + id).css('display','block');
    }
    function hideUpdateSubcategory(id) {
      $('#subcatname' + id).css('display','block');
      $('#showSBtn' + id).css('display','block');
      $('#subcatnameinput' + id).css('display','none');
      $('#updateSBtn' + id).css('display','none');
      $('#cancelSBtn' + id).css('display','none');
    }
  </script>
@stop