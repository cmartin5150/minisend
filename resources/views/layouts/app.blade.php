<html>
	<head>
		<title>MiniSend - @yield('title')</title>
		
		<!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #222;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #000;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        
        <script src="{{ asset('js/app.js') }}" defer></script>
	</head>
	<body>
		<h1>@yield('title')</h1>
		
		@section('menu')
			<ul>
				<li>
					<a href="{{ route('home') }}">Home</a>
				</li>
        		<li>
        			<a href="{{ route('create_email') }}">Create an Email</a>
        		</li>
        		<li>
        			<a href="{{ route('list_emails') }}">List Emails</a>
        		</li>
        	</ul>
		@show

		<div class="container">
			@yield('content')
		</div>
	</body>
</html>