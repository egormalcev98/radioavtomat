
$(document).ready(function(){
    $('div.alert').not('.alert-important').delay(1000).fadeOut(350);

    //Initialize Select2 Elements
    $('.select2').select2({
        language: Main.autocompleteLanguageConfig
    });

    $('[data-toggle="tooltip"]').tooltip();

    if($('input').is('[data-input-mask="phone"]')) {
        $('[data-input-mask="phone"]').mask('+7(999)999-99-99');
    }

});

let Main = {
    confDrp: {
        "format": "DD.MM.YYYY",
        "separator": " - ",
        "applyLabel": "Применить",
        "cancelLabel": "Отменить",
        "fromLabel": "От",
        "toLabel": "До",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Вс",
            "Пн",
            "Вт",
            "Ср",
            "Чт",
            "Пт",
            "Сб"
        ],
        "monthNames": [
            "Январь",
            "Февраль",
            "Март",
            "Апрель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
        ],
        "firstDay": 1
    },

    autocompleteLanguageConfig: {
        errorLoading: function () {
            return 'Результат не может быть загружен.';
        },
        inputTooLong: function (args) {
            let overChars = args.input.length - args.maximum;
            let message = 'Пожалуйста, удалите ' + overChars + ' символ';
            if (overChars >= 2 && overChars <= 4) {
                message += 'а';
            } else if (overChars >= 5) {
                message += 'ов';
            }
            return message;
        },
        inputTooShort: function (args) {
            let remainingChars = args.minimum - args.input.length;

            let message = 'Пожалуйста, введите ' + remainingChars + ' или более символов';

            return message;
        },
        loadingMore: function () {
            return 'Загружаем ещё ресурсы…';
        },
        maximumSelected: function (args) {
            let message = 'Вы можете выбрать ' + args.maximum + ' элемент';

            if (args.maximum  >= 2 && args.maximum <= 4) {
                message += 'а';
            } else if (args.maximum >= 5) {
                message += 'ов';
            }

            return message;
        },
        noResults: function () {
            return 'Ничего не найдено';
        },
        searching: function () {
            return 'Поиск…';
        }
    },
    loaderHtml: '<i class="fa fa-refresh fa-spin"></i>',

    ajaxRequest: function(typeRequest, urlRequest, dataRequest, successFunction, errorFunction, returnFunction){
        if(typeRequest && urlRequest && typeof dataRequest == 'object' && successFunction){
            let request = $.ajax({
                type   		: typeRequest,
                url    		: urlRequest,
                cache  		: false,
                data 	  	: dataRequest,
                processData	: false,
                contentType	: false,
                success 	: successFunction,
                error		: errorFunction
            });
            if(returnFunction === true)
                return request;
            else
                return true;
        }
        return false;
    },

    modalWithInformation: null,

    popUp: function(text, title){
        let thisGeneral = this;

        if(text){

            if(!title){
                title = 'Информация';
            }

            text = '<p>' + text + '</p>';

            if(thisGeneral.modalWithInformation){
                thisGeneral.modalWithInformation.changeTitle(title);
                thisGeneral.modalWithInformation.changeBody(text);
            } else {
                thisGeneral.modalWithInformation = new ModalApp.ModalProcess({
                    id: 'modal_with_information_data',
                    title: title,
                    body: text,
                    g_style: 'z-index: 99999;'
                });
            }

            thisGeneral.modalWithInformation.init();
            thisGeneral.modalWithInformation.showModal();

            return true;
        }
        return false;
    },

    modalWithConfirm: null,

    modalConfirm: function(text, action){
        let thisGeneral = this;

        if(text && action){

            text = '<p>' + text + '</p>';

            if(thisGeneral.modalWithConfirm){
                thisGeneral.modalWithConfirm.changeBody(text);
            } else {
                thisGeneral.modalWithConfirm = new ModalApp.ModalProcess({
                    id: 'modal_with_confirm',
                    title: 'Подтвердите действие:',
                    body: text,
                    style: 'width: 30%;',
                    footer: '<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>\
							<button type="button" onclick="' + action + '" class="btn btn-success">Хорошо</button>'
                });
            }

            thisGeneral.modalWithConfirm.init();
            thisGeneral.modalWithConfirm.showModal();

            return true;
        }
        return false;
    },

    destroyElement: null,

    deleteMethodLE: function(urlDestroy, elementName, table, usFunc){
        let thisGeneral = this;

        if(urlDestroy){
            thisGeneral.destroyElement = function () {
                if(!table){
                    table = window.LaravelDataTables["dtListElements"];
                }

                let data = new FormData();
                data.append('_token', config.token);
                data.append('_method', 'DELETE');

                let successFunction = function (data) {
                    if(data['action'] && data['action'] == 'reload_table'){
                        table.ajax.reload( null, false );
                    }

                    if(data['error']) {
                        alert(data['error']);
                        throw new Error(data['error']);
                    }


                    if(usFunc){
                        usFunc();
                    }
                };

                thisGeneral.ajaxRequest('POST', urlDestroy, data, successFunction);

                if(elementName != undefined && elementName != null){
                    thisGeneral.modalWithConfirm.hideModal();
                }
            };

            if(elementName === undefined || elementName === null){
                thisGeneral.destroyElement();
            } else {
                thisGeneral.modalConfirm('Вы действительно хотите удалить запись с наименованием "' + elementName + '"?', 'Main.destroyElement();');
            }

        }

        return true;
    },

    updateDataTable: function(e, table){
        if(!table){
            table = window.LaravelDataTables["dtListElements"];
        }

        table.draw();
        e.preventDefault();
    },

    buttonLoading: function(selectorButton){
        if(selectorButton){
            selectorButton.attr('data-loading-text', selectorButton.text());
            selectorButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Выполняем...');
        }

        return true;
    },

    buttonReset: function(selectorButton){
        if(selectorButton){
            selectorButton.text(selectorButton.data('loading-text'));
            selectorButton.removeAttr('data-loading-text');
        }

        return true;
    },

    sendFormData: function(event, selectorForm, successEvent, formData){
        if(event && selectorForm && successEvent){
            event.preventDefault();

            let thisGeneral = this,
                selectorButton = selectorForm.find('button[type="submit"]');

            let errorHandle = function(jqXHR, textStatus, errorThrown ){
                let data = jqXHR.responseJSON;

                if(data['errors'] && data['message']){
                    thisGeneral.displayAllErrors(data['errors'], selectorForm);
                } else {
                    thisGeneral.outputValidatorError('Произошла ошибка, попробуйте еще раз', selectorForm);
                }

                thisGeneral.buttonReset(selectorButton);
            };

            let successHandle = function(arrayData){
                successEvent(arrayData);
                thisGeneral.buttonReset(selectorButton);
            };

            if(!formData) {
                formData = new FormData(selectorForm[0]);
            }

            thisGeneral.buttonLoading(selectorButton);

            thisGeneral.ajaxRequest('POST', selectorForm.attr('action'), formData, successHandle, errorHandle);

            return true;
        }
        return false;
    },

    outputValidatorError: function(error, selectorBlock){
        if(selectorBlock){
            this.collectMessageBlock(error, selectorBlock, 'danger');

            return true;
        }

        return false;
    },

    displayAllErrors: function(dataErrors, selectorBlock){
        if(selectorBlock){
            let thisGeneral = this;

            if(dataErrors) {
                $.each(dataErrors, function(name, msgData){
                    let formElement = selectorBlock.find('[name="' + name + '"]');
					
                    if(formElement.length > 0) {
                        if(!formElement.hasClass('is-invalid')) {
                            formElement.addClass('is-invalid');
                            formElement.parent().append('\
								<div class="invalid-feedback">\
									' + msgData[0] + '\
								</div>\
							');
                        }
                    } else {
                        // console.log(Object.values(dataErrors)[0]);
                        thisGeneral.outputValidatorError(msgData[0], selectorBlock);
                    }
                });
            } else {
                let errorElements = selectorBlock.find('.is-invalid');

                $.each(errorElements, function(key, elem){
                    let formElement = $(this);

                    formElement.removeClass('is-invalid');
                    formElement.next('.invalid-feedback').remove();
                });
            }

            return true;
        }

        return false;
    },

    outputMsgSuccess: function(msg, selectorBlock){
        if(selectorBlock){
            this.collectMessageBlock(msg, selectorBlock, 'success');

            return true;
        }

        return false;
    },

    collectMessageBlock: function(msg, selectorBlock, classBlock){
        if(selectorBlock && classBlock){

            let html = '<div class="col-12">\
							<div class="alert alert-' + classBlock + ' alert-important row">\
								<p>' + msg + '</p>\
							</div>\
						</div>';

            selectorBlock.find('.alert-' + classBlock)/*.parent('div')*/.remove();

            if(msg){
                if(selectorBlock.find('.modal-body').html()){
                    selectorBlock.find('.modal-body').append(html);
                } else {
                    selectorBlock.prepend(html);
                }
            }

            return true;
        }

        return false;
    },

    clearAllMessages: function(selectorBlock){
        if(selectorBlock){
            this.outputValidatorError(null, selectorBlock);

            this.displayAllErrors(null, selectorBlock);

            this.outputMsgSuccess(null, selectorBlock);

            return true;
        }

        return false;
    },

    methodFormReferences: 'POST',

    sendFormDataReferences: function(event, selectorForm, table){
        if(event && selectorForm){
            let thisGeneral = this;

            if(!table){
                table = window.LaravelDataTables["dtListElements"];
            }

            let successEvent = function(arrayData){
                if(arrayData['status'] && arrayData['status'] == 'success'){
                    selectorForm.parents('.modal').modal('hide');

                    table.ajax.reload( null, false );

                    thisGeneral.clearAllMessages(selectorForm);
                } else {
                    thisGeneral.outputValidatorError('Произошла ошибка при сохранении', selectorForm);
                }
            };

            formData = new FormData(selectorForm[0]);

            formData.append('_method', thisGeneral.methodFormReferences);

            thisGeneral.sendFormData(event, selectorForm, successEvent, formData);

            return true;
        }
        return false;
    },

    resetModalValues: function(modalElement){
        let thisGeneral = this,
            formS = modalElement.find('form');

        $.each(formS.find('select'), function( key, selData ) {
            let selector = $(selData);

            selector.val(selector.find('option').first().val());
        });

        formS.find('input:not([type=hidden])').val('');

        return true;
    },

    createModalReferences: function(actionUrl, modalSelector){
        if(actionUrl){
            let thisGeneral = this,
                modalElement = $(modalSelector);

            thisGeneral.methodFormReferences = 'POST';

            modalElement.find('form').attr('action', actionUrl);

            thisGeneral.resetModalValues(modalElement);

            modalElement.modal('show');

            return true;
        }
        return false;
    },

    getDataModalReferences: function(thisSelector, actionUrl, modalSelector, table){
        if(thisSelector && actionUrl && modalSelector){
            let thisGeneral = this,
                tr = thisSelector.parents('tr'),
                modalElement = $(modalSelector);

            if(!table){
                table = window.LaravelDataTables["dtListElements"];
            }

            data = table.row(tr).data();

            if(data) {
                thisGeneral.methodFormReferences = 'PATCH';

                modalElement.find('form').attr('action', actionUrl);

                $.each(data, function( key, value ) {
                    modalElement.find('[name=' + key + ']').val(value);
                });

                modalElement.modal('show');
            }

            return true;
        }
        return false;
    },

}


let Chat = {
	changeStructuralUnit: function(selector){
        if(selector){
			
			if(selector.val()) {
				$('#chat_users').val(null).trigger('change');
			}
			
            return true;
        }
        return false;
    },
	
	currentChannelUser: null,
	
	changeUser: function(selector, Pusher, authId){
        if(selector && Pusher && authId){
			let thisMain = this;
			
			if (thisMain.currentChannelUser !== null) {
				Pusher.unsubscribe(thisMain.currentChannelUser);
				thisMain.currentChannelUser = null;
			}
			
			if(selector.val()) {
				$('#chat_structural_units').val(null).trigger('change');
				
				thisMain.listenUserchannel(Pusher, authId, selector.val());
			}
			
            return true;
        }
        return false;
    },
	
	listenUserchannel: function(Pusher, authId, toUserId){
		if(Pusher && authId && toUserId){
			let thisMain = this;
			
			let channelId = [authId, toUserId].sort(function(a, b) {
			  return a - b;
			}).join('.');
			
			thisMain.currentChannelUser = Pusher.subscribe('chat_user.' + channelId);
			
			thisMain.currentChannelUser.bind('newMessage', function (data) {
				alert('MESSAGA');
			});
			
            return true;
        }
        return false;
	},
	
    sendMessage: function(event){
        if(event){
			event.preventDefault();

            let thisMain = this,
				selectorForm = $('#chat_form'),
                selectorButton = selectorForm.find('button[type="submit"]'),
				buttonHtml = selectorButton.html();

            let errorHandle = function(jqXHR, textStatus, errorThrown ){
                let data = jqXHR.responseJSON;

                if(data['errors'] && data['message']){
                    Main.displayAllErrors(data['errors'], selectorForm);
                } else {
                    Main.popUp('Произошла ошибка при отправке сообщения, обратитесь к администратору');
                }

				selectorButton.html(buttonHtml);
            };

            let successEvent = function(arrayData){
                if(arrayData['status'] && arrayData['status'] == 'success'){
					console.log(arrayData);
					Main.clearAllMessages(selectorForm);
                } else {
                    Main.popUp('Произошла ошибка при отправке сообщения, обратитесь к администратору');
                }
				
				selectorButton.html(buttonHtml);
            };

            formData = new FormData(selectorForm[0]);
			
            selectorButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            Main.ajaxRequest('POST', selectorForm.attr('action'), formData, successEvent, errorHandle);

            return true;
        }
        return false;
    },

}
