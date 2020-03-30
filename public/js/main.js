
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

var Main = {
	
	autocompleteLanguageConfig: {
		errorLoading: function () {
			return 'Результат не может быть загружен.';
		},
		inputTooLong: function (args) {
			var overChars = args.input.length - args.maximum;
			var message = 'Пожалуйста, удалите ' + overChars + ' символ';
			if (overChars >= 2 && overChars <= 4) {
				message += 'а';
			} else if (overChars >= 5) {
				message += 'ов';
			}
			return message;
		},
		inputTooShort: function (args) {
			var remainingChars = args.minimum - args.input.length;

			var message = 'Пожалуйста, введите ' + remainingChars + ' или более символов';

			return message;
		},
		loadingMore: function () {
			return 'Загружаем ещё ресурсы…';
		},
		maximumSelected: function (args) {
			var message = 'Вы можете выбрать ' + args.maximum + ' элемент';

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
			var request = $.ajax({
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
		var thisGeneral = this;
		
		if(text){
			
			if(!title){
				title = 'Информация';
			}
			
			text = '<h3>' + text + '</h3>';
			
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
		var thisGeneral = this;
		
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
				Main.destroyElement();
			} else {
				thisGeneral.modalConfirm('Вы действительно хотите удалить запись с наименованием "' + elementName + '"?', 'Main.destroyElement();');
			}
			
		}
		
		return true;
	},
}