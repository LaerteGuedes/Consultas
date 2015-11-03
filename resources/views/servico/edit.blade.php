@extends('site')

@section('title','Editar Serviço')

@section('content')


<section class="main">

    <div class="container">


         <div class="row">
             <div class="col-lg-12">
                     <ol class="breadcrumb">
                       <li><a href="{{ route('dashboard')  }}">Início</a></li>
                       <li><a href="{{ route('servicos')  }}">Meus Serviços</a></li>
                       <li class="active">Editar Serviço</li>
                     </ol>
             </div>
         </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                <!-- Painel padrão -->
                <div class="panel panel-default">
                  <div class="panel-body">
                    <h3>Editar Serviço</h3>
                  </div>
                </div>
                <!-- /Painel padrão -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                    @include('servico.form')

            </div>
        </div>

    </div>

</section>

@endsection

