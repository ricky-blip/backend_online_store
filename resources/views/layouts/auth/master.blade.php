
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spica Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{ asset('admin-template/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-template/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('admin-template/css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('admin-template/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
      @yield('content')
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{ asset('admin-template/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <script src="{{ asset('admin-template/js/jquery.cookie.js') }}" type="text/javascript"></script>
  <!-- inject:js -->
  <script src="{{ asset('admin-template/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin-template/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('admin-template/js/template.js') }}"></script>
  <!-- endinject -->
</body>

</html>
