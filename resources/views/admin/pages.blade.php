@extends('adminlte::page')

@section('title', 'Pages | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Pages</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>
            Page List
            <div class="pull-right">
              <a href="{{ route('admin.createpage') }}" class="btn btn-success btn-sm" title="Create Page"><i class="fa fa-plus"></i></a>
            </div>
          </h4>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Slug</th>
                <th width="20%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pages as $page)
              <tr>

                <td>{{ $page->title }}</td>
                <td>
                  <img src="{{ asset('images/pages/' . $page->image) }}" alt="" style="height: 70px; width: auto;">
                </td>
                <td><a href="{{ route('index.article', $page->slug) }}" target="_blank">Open Page</a></td>
                <td>
                  <a href="{{ route('admin.editpage', $page->id) }}" class="btn btn-warning btn-sm" title="Edit Page"><i class="fa fa-pencil"></i></a>
                  
                  <button class="btn btn-sm btn-danger" type="button" title="Delete Page" data-toggle="modal" data-target="#deleteModal{{ $page->id }}" data-backdrop="static"><i class="fa fa-trash"></i></button>
                  <div class="modal fade" id="deleteModal{{ $page->id }}" role="dialog" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                          <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                          <h4>Confirm Delete</h4>
                        </div>
                        {!! Form::model($page, ['route' => ['admin.deletepage', $page->id], 'method' => 'DELETE', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                          <center>
                            <big>Are you sure to delete this Page?</big><br/><br/>
                            <h3>{{ $page->title }}</h3>
                            <img src="{{ asset('images/pages/' . $page->image) }}" alt="" class="img-responsive">
                          </center>
                        </div>
                        <div class="modal-footer noPrint">
                          <button type="submit" class="btn btn-danger" title="Delete Page"><i class="fa fa-trash"></i> Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left: 10px;">Close</button>
                        </div>
                        {{ Form::close() }}
                      </div>
                    </div>
                  </div>
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

@section('js')
<script type="text/javascript">
  
</script>
@stop