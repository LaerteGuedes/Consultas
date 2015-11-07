<div class="form-group">
    <label for="plano_pai"></label>
    <h3>Escolha a empresa</h3>
    <form action="{{route('plano.salvar')}}" method="post">
        @foreach($planos as $plano)
            <div class="checkbox-inline checkbox-categoria">
                <input type="checkbox" value="{{$plano->id}}"> {{$plano->titulo}}
            </div>
        @endforeach

        <div id="planos">

        </div>
            <br><br>
        <div class="form-group submit-form">
            <button class="btn btn-success">Enviar</button>
        </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</div>
<script>
    $(function(){
        $(".checkbox-categoria input").on("change", function(){
            var checked = $(this).prop('checked');

            if (checked){
                var value = $(this).val();

                if (value){
                    var params = {id:value};
                    $.ajax({
                        url: "{{route('plano.ajaxplano')}}",
                        method: "get",
                        dataType: "json",
                        data: params,
                        success: function(json){
                            var planoClass = '.planos-'+json.planoPai.id;

                            if (!$(planoClass).html()){
                                var html = '<div class="planos-'+json.planoPai.id+'">';
                                html += '<h4>Planos de saude da '+json.planoPai.titulo+': </h4>';

                                $.each(json.planos, function(index, value){
                                    html += '<div class="checkbox"><input type="checkbox" name="planos[]" value="'+value.id+'"/>'+' '+value.titulo+"</div>";
                                });
                                html += '</div>';
                                $("#planos").append(html);
                            }
                        }
                    });
                }
            }else{
                var planoSelector = ".planos-"+$(this).val();

                $(planoSelector).remove();
            }
        });
    });
</script>
