<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Home | E-Shopper</title>
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{ asset('/frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('/frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('/frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('/frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/frontend/css/rate.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head><!--/head-->

<body>
@include('frontend.layout.header')
<section>
    <div class="container ">
        <div class="row">
            <div class="col-sm-9 padding-right">
                @yield('content')
            </div>
            
        </div>
    </div>
</section>
@include('frontend.layout.footer')

<script src="{{ asset('/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/frontend/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('/frontend/js/price-range.js') }}"></script>
<script src="{{ asset('/frontend/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('/frontend/js/main.js') }}"></script>


<script>
        if(screen.width <= 736){
            document.getElementById("viewport").setAttribute("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");
        }
    </script>


<script>
    	
    	$(document).ready(function(){
			//vote
			$('.ratings_stars').hover(
	            // Handles the mouseover
	            function() {
	                $(this).prevAll().andSelf().addClass('ratings_hover');
	                // $(this).nextAll().removeClass('ratings_vote'); 
	            },
	            function() {
	                $(this).prevAll().andSelf().removeClass('ratings_hover');
	                // set_votes($(this).parent());
	            }
	        );

			$('.ratings_stars').click(function(){
				var Values =  $(this).find("input").val();
		        alert(Values);
		    	if ($(this).hasClass('ratings_over')) {
		            $('.ratings_stars').removeClass('ratings_over');
		            $(this).prevAll().andSelf().addClass('ratings_over');
		        } else {
		        	$(this).prevAll().andSelf().addClass('ratings_over');
		        }
		    });
		});
    </script>

</body>
</html>
