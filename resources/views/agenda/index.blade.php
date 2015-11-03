@extends('site')

@section('title',' | Agenda')

@section('content')


<section>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li><a href="{{ route('dashboard')  }}">Dashboard</a></li>
                      <li class="active">Agenda</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                <div class="page-header">
                    <h1><small>Agenda</small>

                        <a class="btn btn-primary btn-xs pull-right" href="{{ route('nova.agenda') }}">
                            <i class="glyphicon glyphicon-plus"></i>
                            Novo Agendamento
                        </a>
                    </h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12"></div>
                @if($agendas->total() > 0)


                   <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>

                            <th>Local</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Ação</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($agendas as $agenda)
                         <tr>
                             <td>{{ $agenda->localidade->getTipos()[$agenda->localidade->tipo] }}</td>
                             <td>{{ date("d/m/Y",strtotime($agenda->data_agenda)) }}</td>
                             <td>{{ date("H:i",strtotime($agenda->horario_agenda)) }}</td>
                             <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary" href="{{ route('edit.agenda' , $agenda->id )  }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a class="btn btn-danger" href="{{ route('delete.agenda' , $agenda->id )  }}" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true"><i class="glyphicon glyphicon-trash"></i></a>

                                </div>
                             </td>
                         </tr>
                         @endforeach
                     </tbody>
                   </table>


                    <div class="row">
                        <div class="col-lg-12">
                            {!! $agendas->render() !!}
                        </div>
                     </div>

                @else


                    @include('notfound')


                @endif
            </div>
        </div>

    </div>

</section>

@endsection

