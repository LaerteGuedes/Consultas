@extends('site')

@section('title','Nova Especialização')

@section('content')


<section class="main">

    <div class="container">

         <div class="row">
             <div class="col-lg-12">
                     <ol class="breadcrumb">
                       <li><a href="{{ route('dashboard')  }}">Início</a></li>
                       <li><a href="{{ route('ramos')  }}">Minhas Especializações</a></li>
                       <li class="active">Nova Especialização</li>
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

                    @include('ramo.form')

            </div>
        </div>

    </div>

</section>

@endsection


