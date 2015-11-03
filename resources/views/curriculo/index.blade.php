@extends('site')

@section('title', 'Minhas Experiências')

@section('content')


<section class="main">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li><a href="{{ route('dashboard')  }}">Início</a></li>
                      <li class="active">Minhas Experiências</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

            @include('alerts')

            <!-- Painel padrão -->
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <h3>Minhas Experiências
                        <a class="btn btn-primary pull-right" href="{{ route('novo.curriculo') }}">
                            <i class="glyphicon glyphicon-plus"></i>
                            Nova Experiência
                        </a>
                        </h3>
                      </div>
                    </div>
            <!-- /Painel padrão -->

            @if($curriculos->total() > 0)

            <p>{{ $curriculos->total() }} registros.</p>

            <ul class="list-group">
                @foreach($curriculos as $curriculo)
                  <li class="list-group-item">
                      <div class="row">
                          <div class="col-lg-10">
                             
                            <h4 class="list-group-item-heading"><a href="{{ route('edit.curriculo' , $curriculo->id )  }}">{{ $curriculo->descricao }}</a></h4>
                          </div><!-- /.col-lg-7 -->
                          <div class="col-lg-2">
                            <a class="btn btn-primary" href="{{ route('edit.curriculo' , $curriculo->id )  }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="btn btn-danger" href="{{ route('delete.curriculo' , $curriculo->id )  }}" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true"><i class="glyphicon glyphicon-trash"></i></a>

                          </div><!-- /.col-lg-2 -->
                      </div>
                  </li>
                  @endforeach
            </ul>


            {!! $curriculos->render() !!}

            @endif

            </div>
        </div>

    </div>

</section>

@endsection

