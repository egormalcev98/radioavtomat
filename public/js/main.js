
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
	
}