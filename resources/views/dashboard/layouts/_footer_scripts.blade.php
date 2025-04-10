  <!-- BEGIN VENDOR JS-->
  <script src="{{ asset('assets/admin/') }}/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ asset('assets/admin/') }}/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
  <script src="{{ asset('assets/admin/') }}/vendors/js/charts/chartist-plugin-tooltip.min.js" type="text/javascript">
  </script>
  <script src="{{ asset('assets/admin/') }}/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
  <script src="{{ asset('assets/admin/') }}/vendors/js/charts/morris.min.js" type="text/javascript"></script>
  <script src="{{ asset('assets/admin/') }}/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{ asset('assets/admin/') }}/js/core/app-menu.js" type="text/javascript"></script>
  <script src="{{ asset('assets/admin/') }}/js/core/app.js" type="text/javascript"></script>
  <script src="{{ asset('assets/admin/') }}/js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{ asset('assets/admin/') }}/js/scripts/pages/dashboard-ecommerce.js" type="text/javascript"></script>
 @if(Request::is('*/welcome'))
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 @else
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"
 integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
 @endif



  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}

  <!--- Start File Input  -->

  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.4/js/fileinput.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.4/js/locales/LANG.js"></script>
  <!-- To creat Slug  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/speakingurl/14.0.1/speakingurl.min.js"></script>


  <script src="{{ asset('assets/vendor/locale/ar.js') }}"></script>

  @toastifyJs
  @yield('js')
  <script>
      $("#single-image").fileinput({
          theme: 'fa5',
          allowedFileTypes: ['image'],
          language: 'ar',
          maxFileCount: 1,
          enableResumableUpload: false,
          showUpload: false,
          height: 100
      });
  </script>
  <script>
      $("#single-image2").fileinput({
          theme: 'fa5',
          allowedFileTypes: ['image'],
          language: 'ar',
          maxFileCount: 1,
          enableResumableUpload: false,
          showUpload: false,
          height: 100
      });
  </script>
  <!-- END PAGE LEVEL JS-->
