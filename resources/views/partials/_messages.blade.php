<link href="{{ asset('src/css/toastr.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('src/js/toastr.min.js') }}"></script>

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
    toastr.success('{{Session::get('success')}}', 'সফল (SUCCESS)').css('width','400px');
  </script>
@endif


@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
      <script type="text/javascript">
      toastr.error('{{ $error }}', 'ভুল হচ্ছে (ERROR)').css('width','400px');
    </script>
  @endforeach 
@endif

@if(session('error'))
    <script type="text/javascript">
    toastr.error('{{ session('error') }}', 'ভুল হচ্ছে (ERROR)').css('width','400px');
  </script>
@endif

@if(session('info'))
    <script type="text/javascript">
    toastr.info('{{ session('info') }}', 'তথ্য (INFO)').css('width','400px');
  </script>
@endif

@if(session('warning'))
    <script type="text/javascript">
    toastr.warning('{{ session('warning') }}', 'সতর্কীকরণ (WARNING)').css('width','400px');
  </script>
@endif



