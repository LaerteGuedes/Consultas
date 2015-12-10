@extends('adm')
@section('title', 'Profissionais')

@section('content')
    @inject('userService','App\Services\UserService')
    @inject('avaliacaoService','App\Services\AvaliacaoService')

    <section class="main adm">
        <div class="container">
            <div class="row">


                <!-- Sidebar -->
                <div class="col-lg-3">
                  @include('partials.admmenu')
                </div><!-- /.col-lg-3 -->
                <!-- /Sidebar -->


                <!-- Conteúdo -->
                <div class="col-lg-9">
                    <form class="form-inline text-right form-filtro">
                        <div class="form-group">
                            <label>Filtrar por:</label>
                            <input type="text" class="form-control" id="nome" name="name" placeholder="Nome do profissional"/>
                            {{--<select class="form-control">--}}
                                {{--<option value="">Estado</option>--}}
                            {{--</select>--}}
                            <select class="form-control" id="cidade_id" name="cidade_id">
                                <option value="">Cidade</option>
                                @foreach($cidades as $cidade)
                                    <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                @endforeach
                            </select>
                            <select class="form-control" id="especialidade_id" name="especialidade_id">
                                <option value="">Tipo</option>
                                @foreach($especialidades as $especialidade)
                                    <option value="{{$especialidade->id}}">{{$especialidade->nome}}</option>
                                @endforeach
                            </select>
                            <select class="form-control" id="ramo_id" name="ramo_id">
                                <option value="">Especialidade</option>
                            </select>
                            {{--<select class="form-control">--}}
                                {{--<option value="">Assinatura</option>--}}
                            {{--</select>--}}
                            <button class="btn btn-success">Buscar</button>
                        </div>
                    </form>


                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional">

                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Minhas consultas</h2>
                                </div><!-- /.col-lg-10 -->
                                <div class="col-lg-2">
                                    <div class="sub-header"> Data do aviso</div>
                                </div><!-- /.col-lg-2 -->
                            </div>
                        </div>

                        <!-- Lista padrão -->
                        <ul class="list-group">
                            @foreach($profissionais as $profissional)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <a href="{{route('adm.profissionaldetalhe', array('id' => $profissional->id))}}">
                                        @if(!$profissional->thumbnail)
                                            <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                                        @else
                                            <img src="{{ $profissional->thumbnail }}" class="avatar">
                                        @endif
                                        </a>
                                        <h4 class="list-group-item-heading"><a href="{{route('adm.profissionaldetalhe', array('id' => $profissional->id))}}">{{$profissional->name}}</a></h4>
                                        <p class="list-group-item-text">{{$profissional->cid}}<br>{{$profissional->ramo}}</p>
                                    </div><!-- /.col-lg-8 -->
                                    <div class="col-lg-4 text-right">
                                        <span class="blue">Avaliação</span>
                                        <p class="list-group-item-text">
                                            <i class="fa fa-comment"></i> {{ $userService->find($profissional->id)->comentarios()->count()   }} comentários<br>

                                            <?php
                                            $votos = $avaliacaoService->getAvaliacaoProfissional($profissional->id);
                                            ?>

                                            <i class="fa fa-star{{  $votos >= 1 ? '':'-o' }}"></i>
                                            <i class="fa fa-star{{  $votos >= 2 ? '':'-o' }}"></i>
                                            <i class="fa fa-star{{  $votos >= 3 ? '':'-o' }}"></i>
                                            <i class="fa fa-star{{  $votos >= 4 ? '':'-o' }}"></i>
                                            <i class="fa fa-star{{  $votos >= 5 ? '':'-o' }}"></i>

                                            ({{ $votos  }})
                                        </p>
                                    </div><!-- /.col-lg-4 -->
                                </div>
                            </li>
                            @endforeach
                        </ul><!-- /Lista padrão -->

                    </div><!-- /Painel padrão com cabeçalho -->


                    <!-- Paginação -->
                    {!! $profissionais->render() !!}
                    <!-- /Paginação -->


                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection

@section('script')
<script>
    $(function(){
        $('#especialidade_id').on('change', function()
        {

            var self = $(this);
            var especialidade = self.val();
            var url = "{{ url('ajax/listar-ramos')  }}/" + especialidade;

            if(especialidade != "")
            {
                $.get(url, function(response){

                    var options = '';

                    $.each(response.data , function(v,k){

                        options += '<option value="'+ k.id +'">'+ k.nome +'</option>';
                    });

                    $("#ramo_id").empty().html(options);
                    $("#ramo_id").selectpicker('refresh');

                });
            }else{

                var options = '';
                $("#ramo_id").empty().html(options);
                $("#ramo_id").selectpicker('refresh');

            }

        });
    });
</script>

@endsection