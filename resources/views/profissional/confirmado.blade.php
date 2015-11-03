@extends('site')

@section('title','Agendamento Confirmado')

@section('content')
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

                

                <div class="panel panel-default">
                    
                    <div class="panel-heading header-sallus">
                          <div class="row">
                              <div class="col-lg-12">
                                    <h2><i class="fa fa-hospital-o fa-2"></i> Sua consulta está marcada!</h2>
                              </div><!-- /.col-lg-12 -->
                          </div>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="{{ route('consultas') }}" class="btn btn-primary btn-block">Minhas Consultas</a>
                            </div>
                            <div class="col-lg-9">
                                Você pode ver todas as suas consultas agendadas no link “Minhas Consultas” localizado no topo da página.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="#" class="btn btn-primary btn-block">Avisos</a>
                            </div>
                            <div class="col-lg-9">
                                Fique atendo para os avisos de confirmação e cancelamento de consulta.
                            </div>
                        </div>

                    </div>
                    
                </div>

                
           </div><!-- /.col-lg-9 -->
           <!-- /Conteúdo -->
            
          </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->

@endsection