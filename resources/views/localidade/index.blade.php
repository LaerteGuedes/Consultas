@extends('site')

@section('title','Meus Locais de Atendimento')

@section('content')


<section class="main">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li><a href="{{ route('dashboard')  }}">Início</a></li>
                      <li class="active">Meus Locais de Atendimento</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                <!-- Painel padrão -->
                <div class="panel panel-default">
                  
                    <div class="panel-heading header-sallus">
                          <div class="row">
                              <div class="col-lg-12">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Meus Locais de Atendimento 
                                        <a class="btn btn-primary pull-right" href="{{ route('novo.localidade') }}">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            Novo Local
                                        </a>
                                    </h2>
                              </div><!-- /.col-lg-12 -->
                          </div>
                    </div>
                  
                  <div class="panel-body">
                    @if($localidades->total() > 0)

                        <p>{{ $localidades->total() }} registros.</p>

                        <ul class="list-group">
                            @foreach($localidades as $localidade)
                              <li class="list-group-item">
                                  <div class="row">
                                      <div class="col-lg-10">

                                        <a href="{{ route('edit.localidade' , $localidade->id )  }}" class="text-lowercase">
                                       {{ $localidade->tipo }} -  {{ $localidade->logradouro }} {{ $localidade->numero }} , {{ $localidade->bairro->nome }},
                                        {{ $localidade->cidade->nome }} - {{ $localidade->uf }} 
                                        </a>
                                      </div><!-- /.col-lg-7 -->

                                      <div class="col-lg-2 text-right">
                                        <a class="btn btn-primary" href="{{ route('edit.localidade' , $localidade->id )  }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                        <a class="btn btn-danger" href="{{ route('delete.localidade' , $localidade->id )  }}" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true"><i class="glyphicon glyphicon-trash"></i></a>

                                      </div><!-- /.col-lg-2 -->
                                  </div>
                              </li>
                              @endforeach
                        </ul>


                    {!! $localidades->render() !!}

                    @endif
                  </div>
                </div>
                <!-- /Painel padrão -->



            </div>
        </div>

    </div>

</section>

@endsection

