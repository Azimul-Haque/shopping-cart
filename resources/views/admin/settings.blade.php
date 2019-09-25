@extends('adminlte::page')

@section('title', 'Settings | ইকমার্স')

@section('css')

@endsection

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>
            Sliders<br/> (Recommended 3 Sliders for better landing-page loading)
            <div class="pull-right">
              <a href="{{ route('admin.createslider') }}" class="btn btn-success btn-sm" title="Add Slider"><i class="fa fa-plus"></i></a>
            </div>
          </h4>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Button</th>
                <th width="20%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sliders as $slider)
              <tr>
                <td>
                  <img src="{{ asset('images/slider/' . $slider->image) }}" alt="" style="height: 70px; width: auto;">
                </td>
                <td>{{ $slider->title }}</td>
                <td><a href="{{ $slider->url }}" target="_blank">{{ $slider->button }}</a></td>
                <td>
                  <a href="{{ route('admin.editslider', $slider->id) }}" class="btn btn-warning btn-sm" title="Edit Slider"><i class="fa fa-pencil"></i></a>
                  
                  <button class="btn btn-sm btn-danger" type="button" title="Delete Slider" data-toggle="modal" data-target="#deleteModal{{ $slider->id }}" data-backdrop="static"><i class="fa fa-trash"></i></button>
                  <div class="modal fade" id="deleteModal{{ $slider->id }}" role="dialog" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                          <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                          <h4>Confirm Delete</h4>
                        </div>
                        {!! Form::model($slider, ['route' => ['admin.deleteslider', $slider->id], 'method' => 'DELETE', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                          <center>
                            <big>Are you sure to delete this Slider?</big><br/><br/>
                            <img src="{{ asset('images/slider/' . $slider->image) }}" alt="" class="img-responsive">
                          </center>
                        </div>
                        <div class="modal-footer noPrint">
                          <button type="submit" class="btn btn-danger" title="Delete Slider"><i class="fa fa-trash"></i> Delete</button>
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
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>
            Give away percentage
            <div class="pull-right">

            </div>
          </h4>
        </div>
        {!! Form::model($setting, ['route' => ['admin.updatesetting', $setting->id], 'method' => 'PUT']) !!}
        <div class="panel-body">
            {!! Form::label('give_away_percentage', 'Percentage') !!}
            <div class="input-group">
              {!! Form::text('give_away_percentage', null, array('class' => 'form-control', 'required' => '')) !!}
              <span class="input-group-addon">%</span>
            </div><br/>

            <div class="checkbox">
              <label><input type="checkbox" value="1" name="checkconfirm" required="">I Understand</label>
            </div>
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection

@section('js')
<script type="text/javascript">
  
</script>
@stop