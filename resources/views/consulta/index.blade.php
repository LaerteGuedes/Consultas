@extends('site')

@section('title','Minhas Consultas')

@section('content')


<section class="main">
  <!--container-->
  <div class="container">
   
    
    @if(Auth::user()->role->name == "Cliente")
        
        @include('consulta.usuario')

    @elseif(Auth::user()->role->name == "Profissional")

      @include('consulta.profissional')

    @endif
    

  </div> 
  <!-- /container -->
</section> 
<!-- /section -->


@endsection

