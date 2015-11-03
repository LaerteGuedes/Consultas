@extends('site')

@section('title','Meu Avisos')

@section('content')


<section class="main">
  <!--container-->
  <div class="container">
   
    
    @if(Auth::user()->role->name == "Cliente")
        
        @include('aviso.usuario')

    @elseif(Auth::user()->role->name == "Profissional")

      @include('aviso.profissional')

    @endif
    

  </div> 
  <!-- /container -->
</section> 
<!-- /section -->


@endsection

