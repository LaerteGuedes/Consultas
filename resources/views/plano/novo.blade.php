@extends('site')
@section('title', 'Adicionar planos de saúde')

@section('content')

    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard')  }}">Início</a></li>
                        <li><a href="{{ route('planos')  }}">Planos de saúde</a></li>
                        <li class="active">Adicionar planos de saúde</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    @include('alerts')
                    <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Nova Especialização

                            </h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    @include('plano.form', ['planos' => $planos, 'vPlanos' => $vPlanos])

                </div>
            </div>

        </div>

    </section>

@endsection