<!doctype html>
<?$uri = Request::server('REQUEST_URI');?>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="/js/jquery.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
    	<nav class="navbar navbar-expand-sm  navbar-dark bg-dark">
    		<div class="container">
	    		<ul class="nav navbar-nav">
				    <li class="nav-item">
				      <a class="nav-link <? echo (!($uri == "/places" or $uri == "/"))?: "active";?>" href="/places">Places</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link <? echo ($uri != "/addplace")?: "active";?>" href="/addplace">Add Place</a>
				    </li>
			  </ul>
		  </div>
    	</nav>
        <div class="container">
           @yield('content')
        </div>
        <footer>
        	<p> Footer </p>
        </footer>
    </body>
</html>
