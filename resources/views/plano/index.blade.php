@extends('site')
@section('title', 'Planos de saúde')

@section('content')
    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard')  }}">Início</a></li>
                        <li class="active">Planos de Saúde atendidos</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    @include('alerts')

                            <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Planos de Saúde atendidos
                                <a class="btn btn-primary pull-right" href="{{ route('plano.novo') }}">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Editar planos de saúde atendidos
                                </a>
                            </h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                    @if($planos->total() > 0)

                        <p>{{ $planos->total() }} registros.</p>

                        <ul class="list-group">
                            @foreach($planos as $plano)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-lg-10">

                                            <h4 class="list-group-item-heading">{{ $plano->titulo }}</h4>
                                        </div><!-- /.col-lg-7 -->
                                        <div class="col-lg-2">
                                            <a class="btn btn-danger" href="{{ route('plano.delete' , array('id' => $plano->id))  }}" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true"><i class="glyphicon glyphicon-trash"></i></a>
                                        </div><!-- /.col-lg-2 -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    @endif
                </div>
            </div>

        </div>

    </section>


@endsection