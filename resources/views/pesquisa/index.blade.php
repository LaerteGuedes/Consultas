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

            <p>{{$users->total() }} profissionais encontrados:</p>
            
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
                          <p class="list-group-item-text">
                            <i class="fa fa-comment"></i> {{ $userService->find($user->id)->comentarios()->count()   }} comentários<br>

                             <?php
                              $votos = $avaliacaoService->getAvaliacaoProfissional($user->id);
                             ?> 

                                 <i class="fa fa-star{{  $votos >= 1 ? '':'-o' }}"></i>
                                 <i class="fa fa-star{{  $votos >= 2 ? '':'-o' }}"></i>
                                 <i class="fa fa-star{{  $votos >= 3 ? '':'-o' }}"></i>
                                 <i class="fa fa-star{{  $votos >= 4 ? '':'-o' }}"></i>
                                 <i class="fa fa-star{{  $votos >= 5 ? '':'-o' }}"></i> 

                            ({{ $votos  }})
                          </p>
                      </div><!-- /.col-lg-3 -->
                      <div class="col-lg-2">
                        
                        <?php

                            $profissional = $userService->find($user->id);
                        ?>
                        
                        @if( $profissional->localidades()->where('tipo','CONSULTORIO')->count())
                          <a href="javascript:void(0);" class="btn btn-primary btn-agendar-multi">Agendar</a>
                            <!-- Painel padrão com locais de atendimento -->
                            <div class="panel panel-default locais-atendimento">
                              <div class="panel-body">
                                    <h4><i class="fa fa-info-circle"></i> Escolha em qual local gostaria de ser atendido:</h4>
                                    <ul class="list-group">
                                      @foreach($profissional->localidades()->where('tipo','CONSULTORIO')->get() as $local)
                                        <li class="list-group-item">
                                        <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}">
                                             {{ $local->logradouro }} {{ $local->numero }}
                                        </a>
                                        </li>
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


@endsection
