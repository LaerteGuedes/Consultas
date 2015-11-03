@extends('site')

@section('title','Entrar')


@section('content')


<section>

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">

                @include('alerts')

                 <h3><small><i class="glyphicon glyphicon-lock"></i></small> Painel de Acesso <br/> <small>Preencha seus dados de acesso!</small></h3>



                <form role="form" method="POST" action="{{ url('/auth/login') }}" class="well">


                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="E-mail"/>
                    </div>

                    <div class="form-group">

                            <input type="password" class="form-control" name="password" placeholder="Senha"/>

                    </div>

                    <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Lembrar-me
                            </label>
                    </div>

                    <div class="form-group">

                        <button type="submit" class="btn btn-primary">Entrar</button>

                        <a class="btn btn-link" href="{{ url('/password/email') }}">Esqueci minha senha.</a>

                    </div>
                </form>



            </div>
        </div>
    </div>

</section>

@endsection
