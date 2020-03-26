			@if(!isset($permissionKey) or (isset($permissionKey) and auth()->user()->can('edit-' . $permissionKey)))
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">{{ __('references.main.save_button') }}</button>
				</div>
			@endif