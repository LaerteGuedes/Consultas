@extends('site')

@section('title',' | Consultas')

@section('style')

   <link rel="stylesheet" href="{{ asset('css/clndr.css') }}"/>

@endsection

@section('content')


<section>

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li><a href="{{ route('dashboard')  }}">Dashboard</a></li>
                      <li class="active">Consultas</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                <div class="page-header">
                    <h1>
                        <small>Consultas Agendadas</small>
                    </h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('consulta.calendar')

            </div>
        </div>

    </div>

</section>

@endsection

