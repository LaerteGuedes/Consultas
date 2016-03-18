@extends('site')
@section('title','Profissional da Saúde')
@section('content')

<section class="main">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Bem- vindo à Sallus</h1>
                <h2 class="text-center">A Plataforma virtual que vai gerenciar sua agenda 24 horas.</h2>
          <p class="text-center lead">Inicie seu período de avaliação gratuita por 30 dias</p>

        </div>
    </div>
</section>
<section class="bk-pro">
    <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-6 col-lg-offset-3">
                    @include('alerts')
                    @include('home.form-profissional')
                </div>
            </div>
    </div>
</section>

@endsection
