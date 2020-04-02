
@if(auth()->user()->can('update_' . $permissionKey))
	<button class="btn btn-xs btn-primary" title="{{ __('references.main.edit_button') }}" onclick="Main.getDataModalReferences($(this), '{{ route($routeName . '.update', $element->id) }}', '#modal_element');" ><i class="fas fa-edit" style="font-size: 17px;"></i>  </button>
	@include('crm.delete_button')
@endif