			
				<div class="col-4 row">
					<div class="form-group">
						<label>Роль пользователя</label>
						<select onchange="Main.updateDataTable(event);" class="form-control select2" name="role">
							<option value="">Ничего не выбрано</option>
							@if($roles->isNotEmpty())
								@foreach($roles as $role)
									<option value="{{ $role->name }}">{!! $role->display_name !!}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				
				<div class="col-4">
					<div class="form-group">
						<label>Структурное подразделение</label>
						<select onchange="Main.updateDataTable(event);" class="form-control select2" name="structural_unit">
							<option value="">Ничего не выбрано</option>
							@if($structuralUnits->isNotEmpty())
								@foreach($structuralUnits as $structuralUnit)
									<option value="{{ $structuralUnit->id }}">{!! $structuralUnit->name !!}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>