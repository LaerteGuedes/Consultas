<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title> Sallus | @yield('title')</title>

    <!-- Gooogle Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,300' rel='stylesheet' type='text/css'>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

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
    <script src="{{ asset('lib/jquery/dist/jquery.min.js')  }}"></script>
    <script src="{{ asset('lib/bootstrap/dist/js/bootstrap.min.js')  }}"></script>
    <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('lib/bootbox.js/bootbox.js') }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="{{ asset('lib/jquery-meiomask/dist/meiomask.js')  }}"></script>
    <script src="{{ asset('lib/bootstrap-filestyle/src/bootstrap-filestyle.min.js')  }}"></script>
    <script src="{{ asset('js/site.js') }}"></script>
</head>
<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="/imagens/header/logo-sallus.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav {{ Request::is('dashboard') ? 'white' : '' }} {{ Request::is('/') ? 'white' : '' }}">

                @if(Auth::guest())
                    <li class="{{ Menu::isActiveRoute('home.cliente') }}"><a href="{{ route('home.cliente') }}">Cadastre-se</a></li>
                    <li class="{{ Menu::isActiveRoute('home.profissional') }}"><a href="{{ route('home.profissional') }}">Profissional da Saúde</a></li>
                    <li class="{{ Menu::isActiveUrl(  url('auth/login') ) }}"><a href="{{  url('auth/login') }}">Entrar</a></li>
                @else

                    @inject('avisoService','App\Services\AvisoService')


                    <li>
                        <a href="{{ route('avisos') }}">Avisos
                            @if(Auth::user()->role->name=="Profissional")

                                @if($avisoService->getTotalAvisosPendentesByProfissional(Auth::user()->id) > 0)
                                    <span class="badge">{{$avisoService->getTotalAvisosPendentesByProfissional(Auth::user()->id)}}</span>
                                @endif


                            @elseif(Auth::user()->role->name=="Cliente")


                                @if($avisoService->getTotalAvisosPendentesByCliente(Auth::user()->id) > 0)
                                    <span class="badge">{{$avisoService->getTotalAvisosPendentesByCliente(Auth::user()->id)}}</span>
                                @endif


                            @endif
                        </a>
                    </li>




                    @if(Auth::user()->role->name=="Profissional")
                        <li><a href="{{ route('grade') }}">Meus Horários</a></li>
                    @endif

                    <li><a href="{{ route('consultas') }}">Minhas Consultas</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i> Configurações<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('edit.perfil') }}"> <i class="glyphicon glyphicon-user"></i> Editar Perfil</a></li>

                            @if(Auth::user()->role->name=="Profissional")
                                <li><a href="{{route('planos') }}"><i class="glyphicon glyphicon-info-sign"> Planos de saúde</i></a></li>
                                <li><a href="{{ route('ramos') }}"> <i class="glyphicon glyphicon-education"> Minhas Especializações</i> </a></li>
                                <li><a href="{{ route('curriculos') }}"> <i class="glyphicon glyphicon-file"> Minhas Experiências</i> </a></li>
                                <li><a href="{{ route('localidades') }}"> <i class="glyphicon glyphicon-map-marker"> Minhas Localidades</i> </a></li>
                                <li><a href="{{ route('servicos') }}"> <i class="glyphicon glyphicon-tasks"> Meus Serviços</i> </a></li>

                            @endif

                            <li><a href="{{ url('/auth/logout') }}"> <i class="glyphicon glyphicon-log-out"></i> Sair</a></li>

                        </ul>
                    </li>


                @endif

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


@yield('content')


        <!-- footer -->
<section class="footer {{ Request::is('/') ? '' : 'top50' }}">
    <div class="container">

        <footer>
            <a href="#">Sobre</a>
            <a href="#">Política de privacidade</a>
            <a href="#">Termos de uso</a>
            <a href="#">Fale conosco</a>
            <a href="#">Profissional da área de saúde?</a>
            <span>Copyright &copy; 2015 Sallus. Todos os direitos reservados.</span>
        </footer>
    </div>
</section>
<!-- fim footer -->

<!--lib-->

@yield('lib')

        <!-- js -->



@yield('script')

@yield('script_filtro')


</body>

</html>