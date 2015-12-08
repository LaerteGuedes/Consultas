@extends('site')

@section('title','Minhas Especializações')

@section('content')


    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard')  }}">Início</a></li>
                        <li class="active">Minhas Especializações</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    @include('alerts')

                            <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Minhas Especializações
                                <a class="btn btn-primary pull-right" href="{{ route('novo.ramo') }}">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Nova Especialização
                                </a>
                            </h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                    @if($ramos->total() > 0)

                        <p>{{ $ramos->total() }} registros.</p>

                        <ul class="list-group">
                            @foreach($ramos as $ramo)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-lg-10">

                                            <h4 class="list-group-item-heading"><a href="{{ route('edit.ramo' , $ramo->ramo->id )  }}">{{ $ramo->ramo->nome }}</a></h4>
                                        </div><!-- /.col-lg-7 -->
                                        <div class="col-lg-2">
                                            <a class="btn btn-primary" href="{{ route('edit.ramo' , $ramo->ramo->id )  }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a class="btn btn-danger" href="{{ route('delete.ramo' , $ramo->id )  }}" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true"><i class="glyphicon glyphicon-trash"></i></a>

                                        </div><!-- /.col-lg-2 -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>


                        {!! $ramos->render() !!}

                    @endif
                </div>
            </div>

        </div>

    </section>

@endsection

