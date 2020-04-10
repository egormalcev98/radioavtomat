
<div class="modal fade" id="modal_distributed">
	<div class="modal-dialog" style="min-width: 1000px;">
		<div class="modal-content">
			<form role="form" method="POST" onsubmit="Main.sendFormDataReferences(event, $(this), window.LaravelDataTables['dtListDistributed']);" action="{{ route('incoming_document_users.save_distributed', $incomingDocument->id) }}" >
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Кому распределено</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-4 row">
						<select class="form-control select2" placeholder="Поиск по сотрудникам" style="width: 100%;" onchange="IncomingDocument.selectEmployeeDistributed($(this));">
							<option value="">Ничего не выбрано</option>
							@if($employees->isNotEmpty())
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" >{{ $employee->fullName }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="mt-2">
						<table class="table">
							<thead>
								<tr>
									<th>ФИО сотрудника</th>
									<th>Задача</th>
									<th>Комментарий</th>
									<th style="min-width: 300px;">Рассмотреть и подписать до</th>
									<th>Выбрать</th>
								</tr>
							</thead>
							<tbody>
								<tr style="display: none;" data-type="hidden_clone">
									<td></td>
									<td>
										<select class="form-control" name="users[*][employee_task_id]">
											@if($employeeTasks->isNotEmpty())
												@foreach($employeeTasks as $employeeTask)
													<option value="{{ $employeeTask->id }}" >{{ $employeeTask->name }}</option>
												@endforeach
											@endif
										</select>	
									</td>
									<td>
										<input type="text" class="form-control" name="users[*][comment]" >
									</td>
									<td>
										<div class="col-12 row">
											<div class="col-7">
												<input type="date" class="form-control" name="users[*][sign_up_date]" >
											</div>
											<div class="col-4 row">
												<input type="time" class="form-control" name="users[*][sign_up_time]" >
											</div>
										</div>
									</td>
									<td>
										<div class="form-check">
											<input type="checkbox" data-type="user_id" class="form-check-input" value="" name="select[]" >
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('references.main.close_button') }}</button>
					<button type="submit" class="btn btn-primary">{{ __('references.main.save_button') }}</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->