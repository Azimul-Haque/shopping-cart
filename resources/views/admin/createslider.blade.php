@extends('adminlte::page')

@section('title', 'Create Slider | LOYAL অভিযাত্রী')

@section('css')

@endsection

@section('content_header')
    <h1>Create Slider
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4>
            Create Slider
          </h4>
        </div>
        {!! Form::open(['route' => 'admin.storeslider', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            <label>Image <big><b>(Size: 500KB Max, width x height : 1360px x 580px)</b></big><br/></label>
            <input type="file" id="image" name="image" required><br/>

            {!! Form::label('title', 'Slider Title') !!}
            {!! Form::text('title', null, array('class' => 'form-control')) !!}<br/>
            
            {!! Form::label('button', 'Button Text (If any, otherwise leave empty)') !!}
            {!! Form::text('button', null, array('class' => 'form-control')) !!}<br/>

            {!! Form::label('url', 'URL of Page from Button (If any, otherwise leave empty)') !!}
            {!! Form::text('url', null, array('class' => 'form-control')) !!}
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-success">Submit</button>
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