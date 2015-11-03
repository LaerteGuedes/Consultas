@extends('site')

@section('title','Registrar Conta')

@section('content')


<section class="main">
    <div class="container">

            <div class="row">

                <div class="col-lg-offset-3 col-lg-6">

                        @include('alerts')

                        <h3><small><i class="glyphicon glyphicon-user"></i></small> Criar Minha Conta <br/><br/> <small>Preencha os campos abaixo.</small></h3>


                        @include('home.form')


                </div>

            </div>

    </div>
</section>

@endsection

@section('lib')

    <script src="{{ asset('lib/vue/dist/vue.min.js') }}"></script>
    <script src="{{ asset('js/bind.js') }}"></script>

@endsection

