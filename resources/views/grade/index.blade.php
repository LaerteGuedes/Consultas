@extends('site')
@section('title','Grade de Horários')
@section('content')

    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard')  }}">Início</a></li>
                        <li class="active">Grade de Horários</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('alerts')
                            <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Configuração dos horários de atendimento
                                <a class="btn btn-primary pull-right" href="{{ route('novo.localidade') }}">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Adicionar local de atendimento
                                </a>
                            </h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if($localidades)
                        @foreach($localidades as $localidade)
                            <h2><small><i class="glyphicon glyphicon-map-marker"></i> - {{ $localidade['local'] }}</small></h2>
                            <table class="table table-bordered table-horario">
                                <thead>
                                <tr>
                                    <th>TURNO</th>
                                    @foreach($dias_semanais as $sigla_dia => $dia)
                                        <th class="text-uppercase">{{ $sigla_dia }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($turnos as $sigla_turno => $turno)
                                    <tr>
                                        <td class="text-uppercase">{{ $turno }}</td>
                                        @foreach($dias_semanais as $sigla_dia => $dia)
                                            <?php
                                            $horarios = $gradeService->getHorariosByUser( Auth::user()->id ,
                                                    [
                                                            'localidade_id' => $localidade['id'],
                                                            'dia_semana'    => $sigla_dia,
                                                            'turno'         => $sigla_turno
                                                    ]);
                                            ?>

                                            <td>
                                                <div class="lista-horarios">
                                                    @if($horarios->count() > 0)
                                                        <ul>
                                                            @foreach($horarios as $horario)
                                                                <li>
                                                                    {{ date("H:i",strtotime($horario->horario)) }}
                                                                    <a href="{{ route('delete.horario.grade' , $horario->id ) }}">
                                                                        <i class="glyphicon glyphicon-remove"></i>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                    @endif
                                                    @if($turno == 'manhã')
                                                        <?php $turnoStr = 'manha';?>
                                                    @elseif($turno == 'tarde' || $turno == 'noite')
                                                        <?php $turnoStr = $turno; ?>
                                                    @endif
                                                    <button  type="button" class="btn btn-primary btn-xs add-horario-<?=$turnoStr;?>" data-localidade_id="{{ $localidade['id']}}" data-dia_semana="{{ $sigla_dia }}" data-turno="{{ $sigla_turno }}"> criar horário</button>
                                                </div>

                                            </td>

                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            <i class="glyphicon glyphicon-info-sign"></i>
                            Por favor crie um local de para consulta.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    <template id="form-horario-manha">
        <form>
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-info-sign"></i>Para criar os horários de atendimento, informe os dados abaixo:
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Início do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_inicio" id="hora_inicio_manha"  class="form-control">
                            @foreach($horasManha as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_inicio" id="minuto_inicio_manha" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Fim do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_final" id="hora_final_manha"  class="form-control">
                            @foreach($horasManha as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_final" id="minuto_final_manha" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Intervalo entre as consultas:</label>
                    </div>
                    <div class="col-xs-6">
                        <select name="intervalo" id="intervalo_manha" class="form-control">
                            @foreach($intervalos_abreviados as $intervalo)
                                <option value="{{$intervalo}}">{{ $intervalo < 60 ? $intervalo . ' minutos': $intervalo/60 . ' hora(s)' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Repetir para:</label>
                    </div>
                    <div class="col-xs-8">
                        <div class="checkbox checkbox-manha">
                            <label>
                                <input type="checkbox" name="dias" value="seg"> seg
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="ter"> ter
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qua"> qua
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qui"> qui
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sex"> sex
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sab"> sab
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="dom"> dom
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </template>

    <template id="form-horario-tarde">
        <form>
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-info-sign"></i>Para criar os horários de atendimento, informe os dados abaixo:
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Início do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_inicio" id="hora_inicio_tarde"  class="form-control">
                            @foreach($horasTarde as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_inicio" id="minuto_inicio_tarde" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Fim do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_final" id="hora_final_tarde"  class="form-control">
                            @foreach($horasTarde as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_final" id="minuto_final_tarde" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Intervalo entre as consultas:</label>
                    </div>
                    <div class="col-xs-6">
                        <select name="intervalo" id="intervalo_tarde" class="form-control">
                            @foreach($intervalos_abreviados as $intervalo)
                                <option value="{{$intervalo}}">{{ $intervalo < 60 ? $intervalo . ' minutos': $intervalo/60 . ' hora(s)' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Repetir para:</label>
                    </div>
                    <div class="col-xs-8">
                        <div class="checkbox checkbox-tarde">
                            <label>
                                <input type="checkbox" name="dias" value="seg"> seg
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="ter"> ter
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qua"> qua
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qui"> qui
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sex"> sex
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sab"> sab
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="dom"> dom
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </template>

    <template id="form-horario-noite">
        <form>
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-info-sign"></i>Para criar os horários de atendimento, informe os dados abaixo:
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Início do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_inicio" id="hora_inicio_noite"  class="form-control">
                            @foreach($horasNoite as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_inicio" id="minuto_inicio_noite" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Fim do atendimento:</label>
                    </div>
                    <div class="col-xs-4">
                        <select name="hora_final" id="hora_final_noite"  class="form-control">
                            @foreach($horasNoite as $hora)
                                <option value="{{ $hora }}">{{ $hora }} h</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="minuto_final" id="minuto_final_noite" class="form-control">
                            @foreach($intervalos as $intervalo)
                                <option value="{{$intervalo}}">{{$intervalo}} min</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Intervalo entre as consultas:</label>
                    </div>
                    <div class="col-xs-6">
                        <select name="intervalo" id="intervalo_noite" class="form-control">
                            @foreach($intervalos_abreviados as $intervalo)
                                <option value="{{$intervalo}}">{{ $intervalo < 60 ? $intervalo . ' minutos': $intervalo/60 . ' hora(s)' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Repetir para:</label>
                    </div>
                    <div class="col-xs-8">
                        <div class="checkbox checkbox-noite">
                            <label>
                                <input type="checkbox" name="dias" value="seg"> seg
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="ter"> ter
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qua"> qua
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="qui"> qui
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sex"> sex
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="sab"> sab
                            </label>
                            <label>
                                <input type="checkbox" name="dias" value="dom"> dom
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </template>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

            $(".add-horario-manha").on('click', function(){

                var btn           = $(this);
                var template      =  $("#form-horario-manha").html().trim();
                var content       = $(template);
                var hora_inicio   = $("#hora_inicio_manha",content);
                var minuto_inicio = $("#minuto_inicio_manha",content);
                var hora_final    = $("#hora_final_manha",content);
                var minuto_final  = $("#minuto_final_manha",content);
                var intervalo     = $("#intervalo_manha",content);
                var checkboxs     = $(".checkbox-manha input:checkbox",content);
                var localidade_id  = btn.data('localidade_id');
                var dia_semana    = btn.data('dia_semana');
                var turno         = btn.data('turno');

                hora_inicio.selectpicker();
                minuto_inicio.selectpicker();
                hora_final.selectpicker();
                minuto_final.selectpicker();
                intervalo.selectpicker();

                bootbox.dialog({
                    message: content,
                    title: 'Adicionar Horários' ,
                    buttons:{
                        main:{
                            label:'Confirmar',
                            className:'btn-success',
                            callback:function()
                            {
                                var dias = [];
                                checkboxs.each(function(){
                                    var self = $(this);
                                    if(self.is(':checked'))
                                    {
                                        if(self.val() !== dia_semana){
                                            dias.push(self.val());
                                        }
                                    }
                                })
                                var data = {
                                    localidade_id:localidade_id,
                                    hora_inicio: hora_inicio.val(),
                                    minuto_inicio: minuto_inicio.val(),
                                    hora_final: hora_final.val(),
                                    minuto_final:minuto_final.val(),
                                    intervalo: intervalo.val(),
                                    dias:dias,
                                    dia_semana:dia_semana,
                                    turno:turno
                                }
                                var url = "{{ url('/store/grade')  }}";
                                $.post(url,data,function(response){
                                    console.log(response);
                                    location.reload();
                                });
                            }
                        }
                    }
                });
            });

            $(".add-horario-tarde").on('click', function(){

                var btn           = $(this);
                var template      =  $("#form-horario-tarde").html().trim();
                var content       = $(template);
                var hora_inicio   = $("#hora_inicio_tarde",content);
                var minuto_inicio = $("#minuto_inicio_tarde",content);
                var hora_final    = $("#hora_final_tarde",content);
                var minuto_final  = $("#minuto_final_tarde",content);
                var intervalo     = $("#intervalo_tarde",content);
                var checkboxs     = $(".checkbox-tarde input:checkbox",content);
                var localidade_id  = btn.data('localidade_id');
                var dia_semana    = btn.data('dia_semana');
                var turno         = btn.data('turno');

                hora_inicio.selectpicker();
                minuto_inicio.selectpicker();
                hora_final.selectpicker();
                minuto_final.selectpicker();
                intervalo.selectpicker();

                bootbox.dialog({
                    message: content,
                    title: 'Adicionar Horários' ,
                    buttons:{
                        main:{
                            label:'Confirmar',
                            className:'btn-success',
                            callback:function()
                            {
                                var dias = [];
                                checkboxs.each(function(){
                                    var self = $(this);
                                    if(self.is(':checked'))
                                    {
                                        if(self.val() !== dia_semana){
                                            dias.push(self.val());
                                        }
                                    }
                                })
                                var data = {
                                    localidade_id:localidade_id,
                                    hora_inicio: hora_inicio.val(),
                                    minuto_inicio: minuto_inicio.val(),
                                    hora_final: hora_final.val(),
                                    minuto_final:minuto_final.val(),
                                    intervalo: intervalo.val(),
                                    dias:dias,
                                    dia_semana:dia_semana,
                                    turno:turno
                                }
                                var url = "{{ url('/store/grade')  }}";
                                $.post(url,data,function(response){
                                    console.log(response);
                                    location.reload();
                                });
                            }
                        }
                    }
                });
            });

            $(".add-horario-noite").on('click', function(){

                var btn           = $(this);
                var template      =  $("#form-horario-noite").html().trim();
                var content       = $(template);
                var hora_inicio   = $("#hora_inicio_noite",content);
                var minuto_inicio = $("#minuto_inicio_noite",content);
                var hora_final    = $("#hora_final_noite",content);
                var minuto_final  = $("#minuto_final_noite",content);
                var intervalo     = $("#intervalo_noite",content);
                var checkboxs     = $(".checkbox-noite input:checkbox",content);
                var localidade_id  = btn.data('localidade_id');
                var dia_semana    = btn.data('dia_semana');
                var turno         = btn.data('turno');

                hora_inicio.selectpicker();
                minuto_inicio.selectpicker();
                hora_final.selectpicker();
                minuto_final.selectpicker();
                intervalo.selectpicker();

                bootbox.dialog({
                    message: content,
                    title: 'Adicionar Horários' ,
                    buttons:{
                        main:{
                            label:'Confirmar',
                            className:'btn-success',
                            callback:function()
                            {
                                var dias = [];
                                checkboxs.each(function(){
                                    var self = $(this);
                                    if(self.is(':checked'))
                                    {
                                        if(self.val() !== dia_semana){
                                            dias.push(self.val());
                                        }
                                    }
                                })
                                var data = {
                                    localidade_id:localidade_id,
                                    hora_inicio: hora_inicio.val(),
                                    minuto_inicio: minuto_inicio.val(),
                                    hora_final: hora_final.val(),
                                    minuto_final:minuto_final.val(),
                                    intervalo: intervalo.val(),
                                    dias:dias,
                                    dia_semana:dia_semana,
                                    turno:turno
                                }
                                var url = "{{ url('/store/grade')  }}";
                                $.post(url,data,function(response){
                                    console.log(response);
                                    location.reload();
                                });
                            }
                        }
                    }
                });
            });
        });

    </script>

@endsection
