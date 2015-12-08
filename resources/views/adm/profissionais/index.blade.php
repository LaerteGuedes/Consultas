@extends('adm')
@section('title', '')

@section('content')
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
                            <input type="text" class="form-control" id="nome" placeholder="Nome do profissional">
                            <select class="form-control">
                                <option value="">Estado</option>
                            </select>
                            <select class="form-control">
                                <option value="">Cidade</option>
                            </select>
                            <select class="form-control">
                                <option value="">Tipo</option>
                            </select>
                            <select class="form-control">
                                <option value="">Especialidade</option>
                            </select>
                            <select class="form-control">
                                <option value="">Assinatura</option>
                            </select>
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
                                        <a href="profissional-detalhe.php"><img src="../img/avatar.jpg" class="avatar"></a>
                                        <h4 class="list-group-item-heading"><a href="profissional-detalhe.php">{{$profissional->name}}</a></h4>
                                        <p class="list-group-item-text">CRM 0123<br>Dermatologista, Clínico Geral</p>
                                    </div><!-- /.col-lg-8 -->
                                    <div class="col-lg-4 text-right">
                                        <span class="blue">Avaliação</span>
                                    </div><!-- /.col-lg-4 -->
                                </div>
                            </li>
                            @endforeach
                        </ul><!-- /Lista padrão -->

                    </div><!-- /Painel padrão com cabeçalho -->


                    <!-- Paginação -->
                    <nav>
                        <ul class="pagination pagination-sm">
                            <li class="disabled"><a href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                            <li class="active"><a href="#">1 <span class="sr-only">(atual)</span></a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                                <a href="#" aria-label="Próximo">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav><!-- /Paginação -->


                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection