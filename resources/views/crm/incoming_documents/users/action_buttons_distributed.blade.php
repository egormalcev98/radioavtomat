
<button class="btn btn-xs btn-primary" title="{{ __('references.main.edit_button') }}" onclick="IncomingDocument.getDataModalUser($(this), '#modal_distributed');" ><i class="fas fa-edit" style="font-size: 17px;"></i>  </button>
	
<button type="button" onclick="Main.deleteMethodLE('{{ route($routeName . '.destroy_distributed', $element->id) }}', '{{ $element->user->full_name }}', window.LaravelDataTables['dtListDistributed']);" class="btn btn-xs btn-danger" title="{{ __('references.main.delete_button') }}" ><i class="fas fa-trash-alt" style="font-size: 17px;"></i></button>