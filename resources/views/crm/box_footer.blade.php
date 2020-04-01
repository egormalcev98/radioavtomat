			@if(!isset($permissionKey) or auth()->user()->can('update_' . $permissionKey))
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">{{ __('references.main.save_button') }}</button>
				</div>
			@endif