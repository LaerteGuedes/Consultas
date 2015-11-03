@extends('site')

@section('title',' | Agenda')


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
                      <!--
                      <li><a href="{{ route('agenda')  }}">Agenda</a></li>
                      -->
                      <li class="active">Agenda</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')



                <div class="page-header">
                    <h1><small>Agenda</small></h1>
                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">

             <div class="alert alert-info">
                                <i class="glyphicon glyphicon-info-sign"></i>
                                Para criar um novo agendamento clique na data correspondente no calendário.
                            </div>

                    @include('agenda.form')
            </div>

        </div>

    </div>

</section>

@endsection

