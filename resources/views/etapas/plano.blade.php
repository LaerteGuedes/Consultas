@extends('site')
@section('title', 'Adicionar planos de saúde')

@section('content')

    <section class="main adm">
        <div class="container">
            <div class="row">
                <!-- Conteúdo -->
                <div class="col-lg-12">
                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional-cadastro">
                        <div class="panel-heading header-sallus">
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="">Local de atendimento</span> <i class="fa fa-angle-right"></i> <span class="">Horários de atendimento</span> <i class="fa fa-angle-right"></i> <span class="ativo">Escolha seus planos de saúde</span></h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div class="text-center">
                                    <h3>Finalize seu cadastro informando quais planos de saúde você atende.</h3>
                                    <p class="lead">Estamos acabando! Agora informe quais planos de saúde você costuma atender seus clientes.</p>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="plano_pai"></label>
                                            <h3>Escolha a empresa</h3>
                                            <form action="{{route('plano.salvar')}}" method="post">
                                                <div class="form-group form-block">
                                                    <label for="nao_atende_planos">Atende planos de saúde? </label>
                                                    <input type="radio" name="nao_atende_planos" value="0"> Sim
                                                    <input type="radio" name="nao_atende_planos" value="1"> Não
                                                </div>
                                                <div id="planos">
                                                    <div class="form-group">
                                                        <label for="plano_pai"></label>
                                                        <h3>Escolha a empresa</h3>
                                                            @if (isset($vPlanos))
                                                                @foreach($vPlanos as $id => $plano)
                                                                    <div class="checkbox-inline checkbox-categoria">
                                                                        @if(isset($plano['checked']))
                                                                            <input type="checkbox" value="{{$id}}" {{$plano['checked']}}> {{$plano['titulo']}}
                                                                        @else
                                                                            <input type="checkbox" value="{{$id}}"> {{$plano['titulo']}}
                                                                        @endif

                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="checkbox-inline checkbox-categoria">
                                                                    <input type="checkbox" value="{{$plano->id}}"> {{$plano->titulo}}
                                                                </div>
                                                            @endif
                                                            <div id="planos">
                                                                @if (isset($vPlanos))
                                                                    @foreach($vPlanos as $id => $plano)
                                                                        @if(isset($plano['filhos']))
                                                                            <div class="planos-{{$id}}">
                                                                                <h4>Planos de saúde da {{$plano['titulo']}}</h4>

                                                                                @foreach($plano['filhos'] as $filho)
                                                                                    <div class="foreach">
                                                                                        <input type="checkbox" name="planos[]" value="{{$filho['id']}}"  {{$filho['checked']}}> {{$filho['titulo']}}
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <br><br>
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </div>
                                                    <script>
                                                        $(function(){
                                                            $(".checkbox-categoria input").on("change", function(){
                                                                var checked = $(this).prop('checked');

                                                                if (checked){
                                                                    var value = $(this).val();

                                                                    if (value){
                                                                        var params = {id:value};
                                                                        $.ajax({
                                                                            url: "{{route('plano.ajaxplano')}}",
                                                                            method: "get",
                                                                            dataType: "json",
                                                                            data: params,
                                                                            success: function(json){
                                                                                var planoClass = '.planos-'+json.planoPai.id;

                                                                                if (!$(planoClass).html()){
                                                                                    var html = '<div class="planos-'+json.planoPai.id+'">';
                                                                                    html += '<h4>Planos de saude da '+json.planoPai.titulo+': </h4>';

                                                                                    $.each(json.planos, function(index, value){
                                                                                        html += '<div class="checkbox"><input type="checkbox" name="planos[]" value="'+value.id+'"/>'+' '+value.titulo+"</div>";
                                                                                    });
                                                                                    html += '</div>';
                                                                                    $("#planos").append(html);
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                }else{
                                                                    var planoSelector = ".planos-"+$(this).val();

                                                                    $(planoSelector).remove();
                                                                }
                                                            });
                                                        });
                                                    </script>

                                                </div>
                                                <br><br>
                                                <div class="form-group submit-form">
                                                    <button class="btn btn-success btn-lg btn-block" >Salvar e finalizar cadastro</button>
                                                </div>
                                                <input type="hidden" name="_token" value="P9vPOjdCDCbtjzu92hNJXccW1uYm4rQ8XyolgQ4Z">
                                            </form>
                                        </div>
                                        <script>
                                            $(function(){
                                                $(".checkbox-categoria input").on("change", function(){
                                                    var checked = $(this).prop('checked');

                                                    if (checked){
                                                        var value = $(this).val();

                                                        if (value){
                                                            var params = {id:value};
                                                            $.ajax({
                                                                url: "/planos/ajaxplano",
                                                                method: "get",
                                                                dataType: "json",
                                                                data: params,
                                                                success: function(json){
                                                                    var planoClass = '.planos-'+json.planoPai.id;

                                                                    if (!$(planoClass).html()){
                                                                        var html = '<div class="planos-'+json.planoPai.id+'">';
                                                                        html += '<h4>Planos de saude da '+json.planoPai.titulo+': </h4>';

                                                                        $.each(json.planos, function(index, value){
                                                                            html += '<div class="checkbox"><input type="checkbox" name="planos[]" value="'+value.id+'"/>'+' '+value.titulo+"</div>";
                                                                        });
                                                                        html += '</div>';
                                                                        $("#planos").append(html);
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    } else {
                                                        var planoSelector = ".planos-" + $(this).val();

                                                        $(planoSelector).remove();
                                                    }
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- /Painel padrão com cabeçalho -->

                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->

@endsection
@section('script')
    <script>
        $(function(){
            var selectorInput = $('input[name="nao_atende_planos"]');
            var target = $('#planos');

            selectorInput.on('change', function(){
                var selectorInputValue = $('input[name="nao_atende_planos"]:checked').val();

                if (selectorInputValue == 1){
                    target.fadeOut();
                }else{
                    target.fadeIn();
                }
            });
        });
    </script>
@endsection