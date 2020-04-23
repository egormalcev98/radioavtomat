
@if(auth()->check())
	<div class="col-md-3" style="position:fixed; bottom:0; right:0;" id="chat_widget">
		<div class="card card-prirary cardutline direct-chat direct-chat-info collapsed-card">
			<div class="card-header">
				<h3 class="card-title">Чат</h3>

				<div class="card-tools">
					<span class="badge bg-info">3</span>
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-plus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
						<i class="fas fa-comments"></i>
					</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body" style="display: none;">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages">
					<!-- Message. Default to the left -->
					<div class="direct-chat-msg">
						<div class="direct-chat-infos clearfix">
							<span class="direct-chat-name float-left">Alexander Pierce</span>
							<span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
						</div>
						<!-- /.direct-chat-img -->
						<div class="direct-chat-text" style="margin: 5px 0 0 0px">
						  Is this template really for free? That's unbelievable!
						</div>
						<!-- /.direct-chat-text -->
					</div>
					<!-- /.direct-chat-msg -->

					<!-- Message to the right -->
					<div class="direct-chat-msg right">
						<div class="direct-chat-infos clearfix">
							<span class="direct-chat-name float-right">Sarah Bullock</span>
							<span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
						</div>
						<!-- /.direct-chat-img -->
						<div class="direct-chat-text" style="margin-right: 1px;">
							You better believe it!
						</div>
						<!-- /.direct-chat-text -->
					</div>
					<!-- /.direct-chat-msg -->
				</div>
				<!--/.direct-chat-messages-->

				<!-- Contacts are loaded here -->
				<div class="direct-chat-contacts" style="background: #ffffff;">
					@if($chatStructuralUnits->isNotEmpty())
						<div class="form-group m-2">
							<label style="color: #000">Отделы</label>
							<select class="form-control select2" style="width: 100%;" id="chat_structural_units" onchange="Chat.changeStructuralUnit($(this));" name="structural_unit_id" form="chat_form">
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