
let OutgoingDocument = {

    checkNumber: function(selectorButton, url){
        if(selectorButton && url){
            let thisGeneral = this;

            let errorHandle = function(jqXHR, textStatus, errorThrown ){
                let data = jqXHR.responseJSON;

                if(data['errors'] && data['message']){
                    Main.popUp(data['errors']['number'][0]);
                } else {
                    Main.popUp('Произошла ошибка, попробуйте еще раз');
                }

                Main.buttonReset(selectorButton);
            };

            let successHandle = function(arrayData){
                if(arrayData && arrayData['status']) {
                    Main.popUp(arrayData['msg']);
                }

                Main.buttonReset(selectorButton);
            };

            let formData = new FormData();
            formData.append('_token', config.token);
            formData.append('number', $('#number_incoming_doc').val());

            Main.buttonLoading(selectorButton);

            Main.ajaxRequest('POST', url, formData, successHandle, errorHandle);

            return true;
        }
        return false;
    },

}
