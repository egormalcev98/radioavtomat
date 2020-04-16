
	@if(!isset($permissionKey) or auth()->user()->can('delete_' . $permissionKey))
		<button type="button" onclick="Main.deleteMethodLE('{{ route($routeName . '.destroy', $element->id) }}', @if(isset($element->name)) '{{ $element->name }}' @elseif(isset($element->display_name)) '{{$element->display_name}}' @else '' @endif);" class="btn btn-xs btn-danger" title="{{ __('references.main.delete_button') }}" ><i class="fas fa-trash-alt" style="font-size: 17px;"></i></button>
	@endif
