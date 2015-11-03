@extends('site')

@section('title','Recuperar Senha')

@section('content')

<section class="main">
    <div class="container">
            <div class="row">
                <div class="col-lg-offset-3 col-lg-6">
                         @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @include('alerts')

                        <h3>Recuperar Senha de acesso <br/> <small>Preencha o campo abaixo e você receberá neste e-mail as instruções de recuperação de senha de acesso.</small></h3>


                        <form class="well" role="form" method="POST" action="{{ url('/password/email') }}">


                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">

                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail"/>

                            </div>

                            <div class="form-group">
                               <button type="submit" class="btn btn-primary">
                                 Enviar
                              </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
</section>


@endsection
