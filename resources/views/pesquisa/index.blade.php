@extends('site')

@section('title',' Resultado')

@section('content')


@inject('userService','App\Services\UserService')
@inject('avaliacaoService','App\Services\AvaliacaoService')

<section class="main">
    <div class="container">
      <div class="row">
          
        <!-- Sidebar -->
        <div class="col-lg-3">
          @include('partials.filtro')
        </div><!-- /.col-lg-3 -->
        <!-- /Sidebar -->
        
        <!-- Conteúdo -->
        <div class="col-lg-9">

          @if($users)

            <p>{{$users->count() }} profissional(is) encontrados:</p>
            
            <!-- Lista padrão -->
            <ul class="list-group">

              @foreach($users as $user)  
              <li class="list-group-item profissional">
                  <div class="row">
                      <div class="col-lg-7">
                          <a href="{{ route('profissional.detalhe' , $user->id) }}">
                            @if(!$user->thumbnail)
                              <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                            @else  
                            <img src="{{ $user->thumbnail }}" class="avatar">
                            @endif
                          </a>
                        <h4 class="list-group-item-heading"><a href="{{ route('profissional.detalhe',$user->id) }}" class="text-capitalize">{{ $user->name }} {{ $user->lastname}}</a></h4>
                        <p class="list-group-item-text text-capitalize">{{ $user->cid }}<br>{{ $user->tipo }} , {{ $user->ramo }}</p>
                      </div><!-- /.col-lg-7 -->
                      <div class="col-lg-3">

                      </div><!-- /.col-lg-3 -->
                      <div class="col-lg-2">
                        
                        <?php

                            $profissional = $userService->find($user->id);
                        ?>
                        
                        @if( $profissional->localidades()->count())
                          <a href="javascript:void(0);" class="btn btn-primary btn-agendar-multi">Agendar</a>
                            <!-- Painel padrão com locais de atendimento -->
                            <div class="panel panel-default locais-atendimento">
                              <div class="panel-body">
                                    <h4><i class="fa fa-info-circle"></i> Escolha em qual local gostaria de ser atendido:</h4>
                                    <ul class="list-group">
                                      @foreach($profissional->localidades()->get() as $local)
                                          @if ($local->tipo == 'CONSULTORIO')
                                                <li class="list-group-item">
                                                    <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="agenda-plano">
                                                        {{ $local->logradouro }} {{ $local->numero }}
                                                    </a>
                                                </li>
                                          @else
                                                <li class="list-group-item">
                                                    <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="agenda-plano">
                                                        Home Care (Domiciliar) - Atendes nos bairros: {{$local->bairro()->first()->nome}}
                                                    </a>
                                                </li>
                                          @endif
                                      @endforeach
                                    </ul>
                              </div>
                            </div><!-- /Painel padrão com locais de atendimento -->
                        @endif

                      </div><!-- /.col-lg-2 -->
                  </div>
              </li>
              @endforeach

   
            </ul><!-- /Lista padrão -->
            
          {!! $users->render() !!}

          @endif
            
            
       </div><!-- /.col-lg-9 -->
       <!-- /Conteúdo -->
       
      </div><!-- /.row -->
    </div> <!-- /container -->
</section> <!-- /section -->
<script>
    $(function(){
        $(".agenda-plano").on("click", function(event){
            event.preventDefault();

            var self = $(this);
            var href = self.attr('href');
            var strHref = href.split('/');
            var profissional_id = strHref[5];
            var data = {'profissional_id' : profissional_id};

            $.ajax({
                url: "/planos/ajaxatendeplano/"+profissional_id,
                method: "get",
                dataType: "json",
                success: function(response){
                    if (!response.atende_planos){
                        if (confirm("Este profissional não atende seu plano de saúde. Deseja continuar na categoria particular?")){
                            window.location.href = href;
                        }
                    }else{
                        window.location.href = href;
                    }
                }
            });
        });
    });
</script>

@endsection
