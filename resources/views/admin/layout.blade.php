<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
   
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{config('app.name')}}</title>
</head>

	<body style="padding:0; margin: 0; border: 0px;">
		@include('admin.header')
		@yield('content')
		<h1>This is example from ItSolutionStuff.com</h1>
	</body>
</html>