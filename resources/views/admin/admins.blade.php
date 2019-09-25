@extends('adminlte::page')

@section('title', 'Admins | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>
      Admins
      <div class="pull-right">
        <a href="{{ route('admin.createadmin') }}" class="btn btn-sm btn-primary" title="সম্পাদনা"><i class="fa fa-plus" aria-hidden="true"></i> Add Admin</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-10">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <i class="fa fa-list-ol" aria-hidden="true"></i> Admin List
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($admins as $admin)
                <tr>
                  <td><big>{{ $admin->name }}</big></td>
                  <td>{{ $admin->phone }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>           
                    <a href="{{ route('admin.editadmin', $admin->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                    <button class="btn btn-sm btn-danger" type="button" title="Delete Admin" data-toggle="modal" data-target="#deleteModal{{ $admin->id }}" data-backdrop="static"><i class="fa fa-trash"></i></button>
                    <div class="modal fade" id="deleteModal{{ $admin->id }}" role="dialog" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header modal-header-danger">
                            <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                            <h4>Confirm Delete</h4>
                          </div>
                          {!! Form::model($admin, ['route' => ['admin.deleteadmin', $admin->id], 'method' => 'DELETE', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                          <div class="modal-body">
                            <center>
                              <big>Are you sure to delete this Admin?</big><br/><br/><br/>
                              <h3>{{ $admin->name }}</h3>
                            </center>
                          </div>
                          <div class="modal-footer noPrint">
                            <button type="submit" class="btn btn-danger" title="Delete Admin"><i class="fa fa-trash"></i> Delete</button>
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
    <div class="col-md-2">
      {{-- <h2><i class="fa fa-calendar-check-o" aria-hidden="true"></i> </h2> --}}
      
    </div>
  </div>
@endsection

@section('scripts')
  
@endsection