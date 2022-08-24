<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>frontend</title>

    <!-- Bootstrap -->
    <link href="{{url('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{url('frontend/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{url('frontend/css/animate.css')}}">
	<link rel="stylesheet" href="{{url('frontend/css/overwrite.css')}}">
	<link href="{{url('frontend/css/animate.min.css')}}" rel="stylesheet"> 
	<link href="{{url('frontend/css/style.css')}}" rel="stylesheet"/>	 
  @livewireStyles 
  </head>

  <body>	
	@include('frontend.partials.header')
	@yield('content')
	@include('frontend.partials.footer')
  @livewireScripts
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{url('frontend/js/jquery-2.1.1.min.js')}}"></script>		
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{url('frontend/js/bootstrap.min.js')}}"></script>	
	<script src="{{url('frontend/js/parallax.min.js')}}"></script>
	<script src="{{url('frontend/js/wow.min.js')}}"></script>
	<script src="{{url('frontend/js/jquery.easing.min.js')}}"></script>
	<script type="{{url('text/javascript')}}" src="{{url('frontend/js/fliplightbox.min.js')}}"></script>
	<script src="{{url('frontend/js/functions.js')}}"></script>
    <script src="{{url('frontend/contactform/contactform.js')}}"></script>

</body>
</html>
