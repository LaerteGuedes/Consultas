<h4>Planos da empresa {{$planoPai->titulo}}</h4>
@foreach($planos as $plano)

    <div class="checkbox-inline">
        <input type="checkbox" name="planos[]" value="{{$plano->id}}"> {{$plano->titulo}}
    </div>
@endforeach