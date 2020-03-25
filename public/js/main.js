
$(document).ready(function(){
	$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
	
	//Initialize Select2 Elements
	$('.select2').select2({
		language: Main.autocompleteLanguageConfig
	});

	$('[data-toggle="tooltip"]').tooltip(); 
	
	if($('input').is('[data-input-mask="phone"]')) {
		$('[data-input-mask="phone"]').mask('+7(999)999-99-99');
	}
});
