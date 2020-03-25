@if ($errors->has($nameField))
	<div class="invalid-feedback">
		{{ $errors->first($nameField) }}
	</div>
@endif