<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Creativo Backend - {{ $title }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="https://creativouae.com/wp-content/uploads/2020/11/favicon.png" type="image/png"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />  <!-- Page plugins -->
  <link rel="stylesheet" href="{{ asset('src/css/dashboard.css') }}" type="text/css">
</head>

<body>
  <div class="wrapper" id="wrapper">
      @yield('content')
  </div>
  <script>
    window.Laravel = <?php echo json_encode(['api_token' => (Auth::user())->api_token]); ?>
  </script>
  <script src="{{ asset('src/js/dashboard.js') }}"></script>
  <script src="{{ asset('src/js/app.js') }}"></script>

</body>
</html>
