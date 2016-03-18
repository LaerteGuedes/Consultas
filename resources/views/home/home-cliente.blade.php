@extends('site')

@section('title','Cadastre-se ')

@section('content')

    <section class="main">
        <div class="container">
            <div class="row">
                <h1 class="text-center">Bem-vindo à SALLUS</h1>
                <h2 class="text-center">A plataforma virtual de agendamento de consultas</h2>
            </div>
        </div>
    </section>


    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @include('alerts')
                    @include('home.form-cliente')
                </div>
            </div>
        </div>
    </section>



@endsection



