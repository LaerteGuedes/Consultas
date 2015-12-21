@extends('site')

@section('title','Profissional da Saúde ')

@section('content')

<section class="main">
    <div class="container">
        <div class="row">
          <h2 class="text-center">Inicie seu período de avaliação gratuita por 30 dias</h2>
          <p class="text-center lead"><strong>SALLUS Secretária  Virtual</strong> irá faciltar sua tarefa de gerenciar sua agenda de atendimentos com seus clientes. </p>

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
