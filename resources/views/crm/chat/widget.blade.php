
@if(auth()->check())
	<div class="col-md-3" style="position:fixed; bottom:0; right:0;" id="chat_widget">
		<div class="card card-prirary cardutline direct-chat direct-chat-info collapsed-card">
			<div class="card-header">
				<h3 class="card-title">Чат</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" onclick="Chat.actionCollapseWidget();">
						<i class="fas fa-plus"></i>
					</button>
					<span class="badge bg-info btn-tool" data-widget="chat-pane-toggle" data-toggle="tooltip" data-placement="top" data-original-title="" style="cursor: pointer; display:none;"></span>
					<button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
						<i class="fas fa-comments"></i>
					</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body" style="display: none;">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages">
					
				</div>
				<!--/.direct-chat-messages-->

				<!-- Contacts are loaded here -->
				<div class="direct-chat-contacts" style="background: #ffffff;">
					@if($chatStructuralUnits->isNotEmpty())
						<div class="form-group m-2">
							<label style="color: #000">Отделы</label>
							<select class="form-control select2" style="width: 100%;" id="chat_structural_units" name="structural_unit_id" form="chat_form">
								<option value="" >Ничего не выбрано</option>
								@foreach($chatStructuralUnits as $sUnit)
									<option value="{{ $sUnit->id }}" >{{ $sUnit->name }}</option>
								@endforeach
							</select>
						</div>
					@endif
					@if($chatUsers->isNotEmpty())
						<div class="form-group m-2">
							<label style="color: #000">Сотрудники</label>
							<select class="form-control select2" style="width: 100%;" id="chat_users" name="to_user_id" form="chat_form">
								<option value="" >Ничего не выбрано</option>
								@foreach($chatUsers as $chatUser)
									<option value="{{ $chatUser->id }}" >{{ $chatUser->full_name }}</option>
								@endforeach
							</select>
						</div>
					@endif
				  <!-- /.contatcts-list -->
				</div>
				<!-- /.direct-chat-pane -->
			</div>
			<!-- /.card-body -->
			<div class="card-footer" style="display: none;">
				<form action="{{ route('chat.send_message') }}" method="post" _lpchecked="1" id="chat_form" onsubmit="Chat.sendMessage(event);">
					@csrf
						
					<div class="input-group">
						<input type="text" name="text" placeholder="Введите сообщение ..." required="required" class="form-control">
						<span class="input-group-append">
							<button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i></button>
						</span>
					</div>
				</form>
			</div>
			<!-- /.card-footer-->
		</div>
		<!--/.direct-chat -->
	</div>
@endif