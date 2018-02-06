<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="{{ URL::to('src/css/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/easy-autocomplete.themes.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/app.css') }}">
    <!-- JS file -->
    @yield('styles')

    {{-- for toaster jquery needs to load first --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('src/js/jquery.easy-autocomplete.min.js') }}"></script>
    {{-- for toaster jquery needs to load first --}}
  </head>
  <body>
  @include('partials.header')
  @include('partials._messages')

  <div class="container-fluid" style="margin-top:70px">
    @yield('content')
  </div>

  {{-- for toaster jquery needs to load first, it is in the upper part, see --}}
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  @yield('scripts')
  </body>
</html>