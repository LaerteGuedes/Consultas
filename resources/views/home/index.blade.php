@extends('site')

@section('title',' | Página Inicial')


@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">

                <!--
                    <img class="img-responsive" src="http://placehold.it/640x300" alt="logo"/>
                -->
                <h3>
                    Encontre o profissional de saúde mais próximo de você!

                        <br/> <br/>

                    <small>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Doloremque iusto labore laborum necessitatibus pariatur praesentium
                        rem saepe, sed similique tempora. Aut dignissimos dolore dolores
                        esse fugit laborum recusandae sapiente ut.

                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Doloremque iusto labore laborum necessitatibus pariatur praesentium
                        rem saepe, sed similique tempora. Aut dignissimos dolore dolores
                        esse fugit laborum recusandae sapiente ut.
                    </small>
                </h3>

            </div>
            <div class="col-lg-5">

             @include('alerts')

             <h3>Abra sua conta! <br/> <small>Basta somente preencher os campos abaixo.</small></h3>


             @include('home.form')

            </div>

        </div>
    </div>
</section>



@endsection


@section('lib')

    <script src="{{ asset('lib/vue/dist/vue.min.js') }}"></script>
    <script src="{{ asset('js/bind.js') }}"></script>

@endsection

