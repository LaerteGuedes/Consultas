(function($){

    $(document).ready(function(){

        $(".disable-button").click(function(){
            $(this).css('pointer-events', 'none');
        })

        /***verificador de abas aberta**/
        var hash = document.location.hash;
        if (hash) {
            $('.nav-tabs a[href=' + hash + ']').tab('show');
        }
        
        $( ".profissional .btn-agendar-multi" ).click(function() {
          $(this).parent().find('.locais-atendimento').toggle( "fast", function() {
            // Animation complete.
          });
        });

        //metodo para mascaras
        $('input[data-mask]').each(function() {
            var input = $(this);
            input.setMask(input.data('mask'));
        });
        //select bootstrap
        $('select').selectpicker();
        //tooltip
        $('[data-toggle="tooltip"]').tooltip();
        //confirm
        $('[data-confirm="true"]').on('click' , function(e){
            var url = $(this).attr("href");
            bootbox.confirm("Você tem certeza que deseja apagar este item?", function(result) {

                if( result === true)
                {
                    window.location = url;
                }
            });

            e.preventDefault();
        });
        //style file input
        $(":file").filestyle();

        function validateProfissional(){
            $("#vue").validate({
                rules: {
                    name: "required",
                    lastname: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    phone: "required",
                    password: {
                        required:true,
                        minlength:5
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: password
                    },
                    cid: "required"
                },
                messages: {
                    name: "Digite o nome",
                    lastname: "Digite o sobrenome",
                    email: {
                        required: "Digite o email",
                        email: "Email invalido"
                    },
                    phone: "Digite o telefone",
                    password: "Digite a senha",
                    password_confirmation: {
                        required: "Confirme a senha",
                        equalTo: "Senha não confere"
                    },
                    cid: "Digite o nº do conselho"
                }
            });
        }
        //validateProfissional();
    });
})(jQuery);

function profissionalConfirmaHideShowPlano(){
    $("input[name='pessoal']").on("change", function(){
        var self = $(this);
        // console.log(self.prop('checked'));
        if (self.val() == 1){
            $("#plano-atendido").fadeOut();
            $("#plano-atendido").find('input:last-child').prop('checked', true);
        }else{
            $("#plano-atendido").fadeIn();
        }
    });
}

function populateFormPlanoSelect(){
    $("#user_plano_empresa").on("change", function(){
        var checked = $(this).find('option:selected');

        if (checked){
            var value = $(this).val();

            if (value){
                var params = {id:value};
                $.ajax({
                    url: "/planos/ajaxplanocliente",
                    method: "get",
                    dataType: "json",
                    data: params,
                    success: function(json) {
                        $("#planos").fadeIn();
                        $("#planos").find('select').html('<option value="">Selecione o plano</option>');

                        for (var i = 0; i < json.planos.length; i++) {
                            $("#id_plano").append('<option value="' + json.planos[i].id + '">' + json.planos[i].titulo + '</option>');
                            $("#id_plano").selectpicker('refresh');
                        }
                    }
                });
            }
        }
    });
}

function excluiRamo(){
    $(".exclui-ramo").on('click', function(){
        if (confirm('Deseja realmente excluir esta especialidade?')){
            var self = $(this);
            var classes = self.attr('class');
            var str = classes.split(' ');
            var classeCampo = str[1];
            var classeCampoF = classeCampo.split('-');
            var ramo_id = classeCampoF[1];
            var rowParent = $("."+classeCampo).parent().parent();

            $.ajax({
                url: "/adm/excluirramo/"+ramo_id,
                method: "get",
                dataType: "json",
                data: "",
                success: function(json){
                    alert(json.message);
                    rowParent.fadeOut();
                }
            });
        }
    });
}

function excluiPlano(){
    $(".exclui-plano").on('click', function(){
        if (confirm('Deseja realmente excluir este plano?')){
            var self = $(this);
            var classes = self.attr('class');
            var str = classes.split(' ');
            var classePlano = str[1];
            var classePlanoF = classePlano.split('-');
            var plano_id = classePlanoF[1];
            var rowParent = $("."+classePlano).parent().parent();

            $.ajax({
                url: "/adm/excluirplano/"+plano_id,
                method: "get",
                dataType: "json",
                data: "",
                success: function(json){
                    alert(json.message);
                    rowParent.fadeOut();
                }
            });
        }
    });
}