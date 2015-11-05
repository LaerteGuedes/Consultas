(function($){

    $(document).ready(function(){

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