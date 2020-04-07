					<div class="card-body row">
						<div class="col-6">
							@if($method == 'edit')
								<div class="form-group">
									<label>ID</label>
									<input type="text" disabled="true" class="form-control" value="{{ $user->id }}">
								</div>
							@endif
							<div class="form-group">
								<label>{{ __('validation.attributes.user_status_id') }}</label>
								<select class="form-control select2 {{ $errors->has('user_status_id') ? 'is-invalid' : '' }}" name="user_status_id" required="required" >
									@if($userStatuses->isNotEmpty())
										@foreach($userStatuses as $userStatus)
											<option value="{{ $userStatus->id }}" @if((@old('user_status_id') and @old('user_status_id') == $userStatus->id) or ($method == 'edit' and $user->user_status_id == $userStatus->id)) selected @endif >{{ $userStatus->name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'user_status_id'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.email') }}</label>
								<input type="email" required="true" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" @if($method == 'edit') value="{{ $user->email }}" @else value="{{ old('email') }}" @endif >
								@include('crm.error_message', ['nameField' => 'email'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.password') }}</label>
								<input type="password" @if($method == 'create') required="true" @endif class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" >
								@include('crm.error_message', ['nameField' => 'password'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.structural_unit_id') }}</label>
								<select class="form-control select2 {{ $errors->has('structural_unit_id') ? 'is-invalid' : '' }}" name="structural_unit_id" required="required" >
									@if($structuralUnits->isNotEmpty())
										@foreach($structuralUnits as $structuralUnit)
											<option value="{{ $structuralUnit->id }}" @if((@old('structural_unit_id') and @old('structural_unit_id') == $structuralUnit->id) or ($method == 'edit' and $user->structural_unit_id == $structuralUnit->id)) selected @endif >{{ $structuralUnit->name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'structural_unit_id'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.role') }}</label>
								<select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" required="required" >
									@if($roles->isNotEmpty())
										@foreach($roles as $role)
											<option value="{{ $role->id }}" @if((@old('role') and @old('role') == $role->id) or ($method == 'edit' and $user->hasRole($role->name))) selected @endif >{{ $role->display_name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'role'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.birthday_at') }}</label>
								<input type="date" class="form-control {{ $errors->has('birthday_at') ? 'is-invalid' : '' }}" name="birthday_at" @if($method == 'edit') value="{{ Carbon\Carbon::parse($user->birthday_at)->format('Y-m-d') }}" @else value="{{ old('birthday_at') }}" @endif >
								@include('crm.error_message', ['nameField' => 'birthday_at'])
							</div>
						</div>
						<div class="col-6">
							@if($method == 'edit')
								<div class="form-group">
									<label>Дата регистрации</label>
									<input type="text" disabled="true" class="form-control" value="{{ $user->created_at }}">
								</div>
							@endif
							<div class="form-group">
								<label>{{ __('validation.attributes.surname') }}</label>
								<input type="text" required="true" class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" name="surname" @if($method == 'edit') value="{{ $user->surname }}" @else value="{{ old('surname') }}" @endif >
								@include('crm.error_message', ['nameField' => 'surname'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.name') }}</label>
								<input type="text" required="true" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" @if($method == 'edit') value="{{ $user->name }}" @else value="{{ old('name') }}" @endif >
								@include('crm.error_message', ['nameField' => 'name'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.middle_name') }}</label>
								<input type="text" required="true" class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" name="middle_name" @if($method == 'edit') value="{{ $user->middle_name }}" @else value="{{ old('middle_name') }}" @endif >
								@include('crm.error_message', ['nameField' => 'middle_name'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.personal_phone_number') }}</label>
								<input data-input-mask="phone" type="text" class="form-control {{ $errors->has('personal_phone_number') ? 'is-invalid' : '' }}" name="personal_phone_number" @if($method == 'edit') value="{{ $user->personal_phone_number }}" @else value="{{ old('personal_phone_number') }}" @endif >
								@include('crm.error_message', ['nameField' => 'personal_phone_number'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.work_phone_number') }}</label>
								<input data-input-mask="phone" type="text" class="form-control {{ $errors->has('work_phone_number') ? 'is-invalid' : '' }}" name="work_phone_number" @if($method == 'edit') value="{{ $user->work_phone_number }}" @else value="{{ old('work_phone_number') }}" @endif >
								@include('crm.error_message', ['nameField' => 'work_phone_number'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.additional') }}</label>
								<input type="text" class="form-control {{ $errors->has('additional') ? 'is-invalid' : '' }}" name="additional" @if($method == 'edit') value="{{ $user->additional }}" @else value="{{ old('additional') }}" @endif >
								@include('crm.error_message', ['nameField' => 'additional'])
							</div>
						</div>
					</div>
					<!-- /.card-body -->
