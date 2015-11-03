@extends('site')

@section('title','Editar Experiência')

@section('content')


<section class="main">

    <div class="container">


         <div class="row">
             <div class="col-lg-12">
                     <ol class="breadcrumb">
                       <li><a href="{{ route('dashboard')  }}">Início</a></li>
                       <li><a href="{{ route('curriculos')  }}">Minhas Experiências</a></li>
                       <li class="active">Editar Experiência</li>
                     </ol>
             </div>
         </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                 <!-- Painel padrão -->
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <h3>Editar Experiência
                   
                        </h3>
                      </div>
                    </div>
                 <!-- /Painel padrão -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                    @include('curriculo.form')

            </div>
        </div>

    </div>

</section>

@endsection

