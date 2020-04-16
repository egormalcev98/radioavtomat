
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

    destroyTrScan: function(selectorButton){
        if(selectorButton){
            selectorButton.parents('tr').remove();

            return true;
        }
        return false;
    },

    addTrScan: function(){
        let cloneTR = $('#clone_file_tr');

        cloneTR.after('<tr>' + cloneTR.html() + '</tr>');

        let newTR = cloneTR.next('tr'),
            fileInput = newTR.find('input[type=file]'),
            timestamp = Date.now();

        fileInput.attr('id', timestamp);
        fileInput.next('label').attr('for', timestamp);

        return true;
    },

    getFileName: function(thisInput){
        if(thisInput){
            if (thisInput.files[0]) { // если выбрали файл
                $(thisInput).parents('td').prev('td').text(thisInput.files[0].name);
            }

            return true;
        }
        return false;
    },

    showFileNameModal: function(name, id){
        if(name && id){
            let modal = $('#modal_file');

            modal.find('#new_file_name').val(name);
            modal.find('[data-file-id]').data('file-id', id);
            modal.modal('show');

            return true;
        }
        return false;
    },

    saveFileNameModal: function(selectorButton){
        if(selectorButton){

            $('#scan_input' + selectorButton.data('file-id'))
                .next('input[type=hidden]')
                .val($('#new_file_name').val())
                .parents('td')
                .prev('td')
                .children('a')
                .text($('#new_file_name').val());

            $('#modal_file').modal('hide');

            return true;
        }
        return false;
    },

}
