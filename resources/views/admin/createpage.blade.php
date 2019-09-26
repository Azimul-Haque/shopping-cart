@extends('adminlte::page')

@section('title', 'Create Page | LOYAL অভিযাত্রী')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote-bs3.css') }}">
@endsection

@section('content_header')
    <h1>Create Page
@stop

@section('content')
  <div class="row">
    <div class="col-md-10">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4>
            Create Page
          </h4>
        </div>
        {!! Form::open(['route' => 'admin.storepage', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            {!! Form::label('title', 'Page Title *') !!}
            {!! Form::text('title', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            <label>Image <big><b>(Size: 500KB Max, width x height : 1200px x 630px)</b></big><br/></label>
            <input type="file" id="image" name="image" required><br/>

            <label for="description" class="text-uppercase">Page Body *</label>
            <textarea type="text" name="description" id="description" class="summernote" required=""></textarea><br/>

            {!! Form::label('slug', 'Slug *, (A-Z, a-z, 0-9, Underscore, No Space & Unique), Example: get_10_percent_discount') !!}
            {!! Form::text('slug', null, array('class' => 'form-control', 'required' => '')) !!}
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
  <script type="text/javascript" src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
  <script type="text/javascript">
    $('.summernote').summernote({
        placeholder: 'Write Body',
        tabsize: 2,
        height: 250,
        dialogsInBody: true
    });
    $('div.note-group-select-from-files').remove();
  </script>
@stop