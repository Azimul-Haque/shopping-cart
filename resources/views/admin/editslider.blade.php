@extends('adminlte::page')

@section('title', 'Edit Slider | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Edit Slider
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4>
            Edit Slider
          </h4>
        </div>
        {!! Form::model($slider, ['route' => ['admin.updateslider', $slider->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            <label>Image <big><b>(If left blank this image will be used, Size: 500KB Max, width x height : 1360px x 580px)</b></big><br/></label>
            <div class="row">
              <div class="col-md-6">
                <input type="file" id="image" name="image">
              </div>
              <div class="col-md-6">
                <img src="{{ asset('images/slider/' . $slider->image) }}" alt="" style="height: 80px; width: auto;">
              </div>
            </div>

            {!! Form::label('title', 'Slider Title') !!}
            {!! Form::text('title', null, array('class' => 'form-control')) !!}<br/>
            
            {!! Form::label('button', 'Button Text (If any, otherwise leave empty)') !!}
            {!! Form::text('button', null, array('class' => 'form-control')) !!}<br/>

            {!! Form::label('url', 'URL of Page from Button (If any, otherwise leave empty)') !!}
            {!! Form::text('url', null, array('class' => 'form-control')) !!}
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