@extends('adminlte::page')

@section('title', 'Product Reviews | LOYAL অভিযাত্রী')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
@endsection

@section('content_header')
    <h1>Product Reviews
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Product Reviews
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condenced table-hover">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Product</th>
                  <th width="10%">Rating</th>
                  <th width="40%">Comment</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reviews as $review)
                  <tr>
                    <td>
                      {{ $review->user->name }}<br/>
                      <small>{{ $review->user->phone }}</small>
                    </td>
                    <td>
                      {{ $review->product->title }}<br/>
                      Category: <span class="label label-success">{{ $review->product->category->name }}</span>, Subategory:<span class="label label-primary">{{ $review->product->subcategory->name }}</span>
                    </td>
                    <td>
                      <p>
                        @if($review->rating >= 1)
                          <i class="fa fa-star black-text"></i>
                        @else
                          <i class="fa fa-star-o black-text"></i>
                        @endif
                        @if($review->rating >= 2)
                          <i class="fa fa-star black-text"></i>
                        @else
                          <i class="fa fa-star-o black-text"></i>
                        @endif
                        @if($review->rating >= 3)
                          <i class="fa fa-star black-text"></i>
                        @else
                          <i class="fa fa-star-o black-text"></i>
                        @endif
                        @if($review->rating >= 4)
                          <i class="fa fa-star black-text"></i>
                        @else
                          <i class="fa fa-star-o black-text"></i>
                        @endif
                        @if($review->rating >= 5)
                          <i class="fa fa-star black-text"></i>
                        @else
                          <i class="fa fa-star-o black-text"></i>
                        @endif
                      </p>
                    </td>
                    <td>{{ $review->comment }}</td>
                    <td>
                      <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $review->id }}" data-backdrop="static" title="Delete">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                      </button>
                      <!-- Modal -->
                      <div class="modal fade" id="deleteModal{{ $review->id }}" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Delete Review</h4>
                            </div>
                            <div class="modal-body">
                              <p>
                                <center>
                                  {{ $review->comment }}<br/><br/>
                                  <big>Confirm delete this review?</big>
                                </center>
                              </p>
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($review, ['route' => ['warehouse.deletereview', $review->id], 'method' => 'DELETE']) !!}
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $reviews->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@stop