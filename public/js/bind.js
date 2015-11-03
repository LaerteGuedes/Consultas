;(function(){

    new Vue({

        el:'#vue',
        data:{
            profissional: false
        },
        methods:{
            showFieldCid: function()
            {
                var self = this;
                var fieldCid = $(self.$$.fieldCid);
                if(self.profissional){
                    fieldCid.prop('disabled',false);
                    fieldCid.attr('required','required')
                }else{
                    fieldCid.prop('disabled',true);
                    fieldCid.removeAttr('required');
                }
            }
        }
    });

})();