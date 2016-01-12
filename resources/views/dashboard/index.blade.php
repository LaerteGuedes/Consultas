@extends('site')

@section('title','Dashboard')

@section('content')
        @if(Auth::user()->role->name=="Profissional")
            <section class="main">
                <div class="container">
                @include('dashboard.profissional')
                </div>
            </section>
        @elseif(Auth::user()->role->name=="Cliente")
            @include('dashboard.cliente')
        @endif
@endsection