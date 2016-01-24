@extends('site')
@section('title', 'Nova assinatura')
@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('dashboard')}}">Início</a></li>
                        <li class="active">Novo Local</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                            <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>{{$message}}</h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                </div>
            </div>
        </div>
    </section>
@endsection