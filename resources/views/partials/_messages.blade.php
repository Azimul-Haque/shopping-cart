<link href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript">
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "400",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
</script>
   
@if (Session::has('success'))
  <script type="text/javascript">
    toastr.success('{{Session::get('success')}}', 'SUCCESS').css('width','400px');
  </script>
@endif


@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
      <script type="text/javascript">
      toastr.error('{{ $error }}', 'ERROR').css('width','400px');
    </script>
  @endforeach 
@endif

@if(session('info'))
    <script type="text/javascript">
    toastr.info('{{ session('info') }}', 'INFO').css('width','400px');
  </script>
@endif

@if(session('warning'))
    <script type="text/javascript">
    toastr.warning('{{ session('warning') }}', 'WARNING').css('width','400px');
  </script>
@endif



