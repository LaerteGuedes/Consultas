<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title> Dike-x @yield('title')</title>

        <!-- css -->
        <link rel="stylesheet" href="{{ asset('lib/bootstrap/dist/css/bootstrap.min.css')  }}"/>
        <link rel="stylesheet" href="{{ asset('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/site.css')  }}"/>

        @yield('style')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
<body>


    	<nav class="navbar navbar-default">
    		<div class="container">
    			<div class="navbar-header">
    				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
    					<span class="sr-only">Toggle Navigation</span>
    					<span class="icon-bar"></span>
    					<span class="icon-bar"></span>
    					<span class="icon-bar"></span>
    				</button>
    				<a class="navbar-brand" href="{{ route('home')  }}">Dike-X</a>
    			</div>

    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    				<ul class="nav navbar-nav navbar-right">

    				        @if( Auth::guest() )
    			            <li class="active">
    			                <a href="{{ url('auth/login')  }}">Entrar</a>
    			            </li>
    			            @else
    			                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Mensagens <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href=""><i class="glyphicon glyphicon-envelope"></i> Joe Doe </a></li>

                                    </ul>
                                </li>
    			            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->email }} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('edit.perfil') }}"> <i class="glyphicon glyphicon-user"></i> Meu Perfil</a></li>
                                    <li><a href="{{ url('/auth/logout') }}"> <i class="glyphicon glyphicon-log-out"></i> Sair</a></li>
                                </ul>
    			            </li>
    			            @endif
    				</ul>
    			</div>
    		</div>
    	</nav>


         @yield('content')



       <footer class="footer">
            <div class="container">

                    <div class="row">
                            <div class="col-lg-12">

                                  <p class="text-center">


                                        <a class="btn-link" href="{{ route('home') }}">www.dikex.com.br</a>

                                  </p>

                            </div>
                    </div>

            </div>

       </footer>

    <!--lib-->

    <script src="{{ asset('lib/jquery/dist/jquery.min.js')  }}"></script>
    <script src="{{ asset('lib/bootstrap/dist/js/bootstrap.min.js')  }}"></script>
    <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('lib/bootbox.js/bootbox.js') }}"></script>
    <script src="{{ asset('lib/jquery-meiomask/dist/meiomask.js')  }}"></script>


    @yield('lib')

    <!-- js -->



    <script src="{{ asset('js/site.js') }}"></script>

    @yield('script')


</body>

</html>