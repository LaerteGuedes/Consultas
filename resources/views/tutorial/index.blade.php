@extends('site')

@section('title','Tutorial')

@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                <!-- Conteúdo -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading header-sallus">
                            <h4>
                                <i class="fa fa-exclamation-circle  fa-2"></i>
                                Olá! Para começar a usar a Sallus você precisa definir os 3 itens abaixo:
                            </h4>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                @if(!isset(Auth::user()->especialidade->especialidade->nome))
                                    <li class="list-group-item">
                                        1º Informe sua área de atuação no seu perfil.
                                        <a href="{{ route('edit.perfil') }}">[Editar Perfil]</a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <s>1º Informe sua área de atuação no seu perfil.</s>
                                    </li>
                                @endif
                                @if(!Auth::user()->localidades()->count())
                                    <li class="list-group-item">
                                        2º Cadastre pelo menos um local da atendimento que você costuma atender seus clientes.
                                        <a href="{{ route('novo.localidade') }}">[Criar Localidade de Atendimento]</a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <s>2º Cadastre pelo menos um local da atendimento que você costuma atender seus clientes.</s>
                                    </li>
                                @endif
                                @if(!Auth::user()->grades->count())
                                    <li class="list-group-item">
                                        3º Após criar seu primeiro local de atendimento, por favor crie sua grade de horários.
                                        <a href="{{ route('grade') }}">[Criar Grade de Horário]</a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <s>3º Após criar seu primeiro local de atendimento, por favor crie sua grade de horários.</s>
                                    </li>
                                @endif
                                @if(!(Auth::user()->assinatura_id && (Auth::user()->assinatura_status == 4 || Auth::user()->assinatura_status == 5)))
                                    <li class="list-group-item">
                                        4º Escolha um pacote de assinatura para utilizar a aplicação.
                                        <a href="{{ route('nova.assinatura') }}">[Selecionar pacote]</a>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <s>4º Escolha um pacote de assinatura para utilizar a aplicação.</s>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection