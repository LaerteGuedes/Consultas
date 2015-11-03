@extends('site')

@section('title','Resetar Senha')

@section('content')


<section class="main">

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
                @include('alerts')

                <h3>Resetar Senha de acesso</h3>

                <form class="well" role="form" method="POST" action="{{ url('/password/reset') }}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">

                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail"/>

                    </div>

                    <div class="form-group">

                        <input type="password" class="form-control" name="password" placeholder="Senha" maxlength="10" />
                        <p class="help-block">* digite pelo meno 5 caracteres e no máximo 10 caracteres.</p>

                    </div>

                    <div class="form-group">

                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Senha" />

                    </div>

                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">
                          Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
