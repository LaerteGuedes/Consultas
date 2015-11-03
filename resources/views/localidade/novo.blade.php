@extends('site')

@section('title','Novo Local')

@section('content')


<section class="main">

    <div class="container">

         <div class="row">
             <div class="col-lg-12">
                     <ol class="breadcrumb">
                       <li><a href="{{ route('dashboard')  }}">Início</a></li>
                       <li><a href="{{ route('localidades')  }}">Meus Locais</a></li>
                       <li class="active">Novo Local</li>
                     </ol>
             </div>
         </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

               <!-- Painel padrão -->
                <div class="panel panel-default">
                  <div class="panel-body">
                    <h3> Novo local de atendimento</h3>
                  </div>
                </div>
                <!-- /Painel padrão -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                    @include('localidade.form')

            </div>
        </div>

    </div>

</section>

@endsection

