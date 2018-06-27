<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <style>
            html {
  position: relative;
  min-height: 100%;
}
body {
  margin-bottom: 60px; /* Margin bottom by footer height */
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 60px; /* Set the fixed height of the footer here */
  line-height: 60px; /* Vertically center the text there */
  background-color: #000;
}
        </style>
    </head>
    <body>
        <footer class="footer">
      <div class="container">
        <div class="row">
        <div class="col-6">
            <span class="text-white"> &copy; {{ config('app.name') }}. All rights reserved
        </div>
        <div class="col-6 justify-content-end d-flex">
            <a href="" class="text-white mr-1">Terms</a>
            <span class="text-white">|</span>
            <a href="" class="text-white ml-1">Privacy Policy</a>
        </div>
    </div>
      </div>
    </footer>
    </body>
</html>
