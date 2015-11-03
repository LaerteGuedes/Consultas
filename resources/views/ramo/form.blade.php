{!!
    Form::open([
        'route'   => isset($ramo->id) ? [ 'update.ramo' , 'id' => $ramo->id ] : 'store.ramo',
        'method'  => isset($ramo->id) ? 'put' : 'post',
        'class'   => 'jumbotron'
     ])
!!}

<div class="form-group">

    {!! Form::label('nome','*Nome:') !!}
    {!! Form::text('nome', isset($ramo->id) ? $ramo->nome : null , [ 'class' => 'form-control','autocomplete'=>'off','data-provide'=>'typeahead' ]) !!}

</div>

<hr/>

<div class="form-group">


    {!! Form::hidden('check_ramo_id',null,['disabled' ,'id' => 'check_ramo_id']) !!}

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}

</div>


{!! Form::close() !!}



@section('lib')

<script src="{{ asset('lib/bootstrap3-typeahead/bootstrap3-typeahead.js') }}"></script>

@endsection


@section('script')

<script type="text/javascript">

$(function(){

    $.get('{{ route('listar.ramos')  }}' ,  function(response){


        $("#nome").typeahead({
            source : response.data,
            autoSelect: true
        });

        $("#nome").change(function(){

            var self            = $(this);
            var check_ramo_id   = $("#check_ramo_id");
            var current         = self.typeahead('getActive');

            if( current.name === self.val() )
            {
                check_ramo_id.prop('disabled',false).val( current.id );

            }else{

                check_ramo_id.prop('disabled',true ).val('');
            }

        });

    });

});

</script>

@endsection

