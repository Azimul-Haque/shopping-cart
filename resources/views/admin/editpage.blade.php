@extends('adminlte::page')

@section('title', 'Edit Page | LOYAL অভিযাত্রী')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote-bs3.css') }}">
@endsection

@section('content_header')
    <h1>Edit Page
@stop

@section('content')
  <div class="row">
    <div class="col-md-10">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4>
            Edit Page
          </h4>
        </div>
        {!! Form::model($page, ['route' => ['admin.updatepage', $page->id], 'method' => 'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
        <div class="panel-body table-responsive">
            {!! Form::label('title', 'Page Title *') !!}
            {!! Form::text('title', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            <label>Image <big><b>(Size: 500KB Max, width x height : 1200px x 630px), If left blank this image will be used</b></big><br/></label>
            <div class="row">
              <div class="col-md-6">
                <input type="file" id="image" name="image">
              </div>
              <div class="col-md-6">
                <img src="{{ asset('images/pages/' . $page->image) }}" alt="" style="height: 100px; width: auto;">
              </div>
            </div>
            <br/>

            <label for="description" class="text-uppercase">Page Body *</label>
            <textarea type="text" name="description" id="description" class="summernote" required="">{!! $page->description !!}</textarea><br/>

            {!! Form::label('slug', 'Slug *, (A-Z, a-z, 0-9, Underscore, No Space & Unique), Example: get_10_percent_discount') !!}
            {!! Form::text('slug', null, array('class' => 'form-control', 'required' => '')) !!}
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