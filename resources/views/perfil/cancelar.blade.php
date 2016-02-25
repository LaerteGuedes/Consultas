@extends('site')

@section('title','Cancelar conta')

@section('content')


    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Deseja realmente cancelar sua conta?</p>

                    <a href="{{route("perfil.excluir")}}" class="btn btn-danger" style="text-align: center">Sim</a>
                    <a href="/" class="btn btn-success" style="text-align: center">Nao</a>

                </div>
            </div>
        </div>

    </section>

@endsection

