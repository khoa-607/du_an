<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Home | E-Shopper</title>

    <!-- CSS -->
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/rate.css') }}" rel="stylesheet">

    <!-- JavaScript -->
    <script src="{{ asset('/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/frontend/js/main.js') }}"></script>

    <!-- Additional CSS Styles -->
    <style>
        .price-range {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .price-range-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .price-range-container {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .price-range-slider {
            width: 100%;
            margin: 0 auto;
            max-width: 300px;
            margin-top: 10px;
        }

        .price-range-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .price-range-label {
            font-size: 16px;
            font-weight: bold;
            color: #666;
        }
    </style>
</head>

<body>
    @include('frontend.layout.header')

    <section>
        <div class="container">
            <div class="row">
                @include('frontend.layout.menu-left1')

                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layout.footer')

    <script>
        $(document).ready(function() {
            // Initialize prettyPhoto
            $("a[rel^='prettyPhoto']").prettyPhoto();

            // Handle mobile viewport adjustment
            if (screen.width <= 736) {
                document.getElementById("viewport").setAttribute("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");
            }

            // Handle star ratings
            $('.ratings_stars').hover(
                function() {
                    $(this).prevAll().andSelf().addClass('ratings_hover');
                },
                function() {
                    $(this).prevAll().andSelf().removeClass('ratings_hover');
                }
            );

            $('.ratings_stars').click(function() {
                var Values = $(this).find("input").val();
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
