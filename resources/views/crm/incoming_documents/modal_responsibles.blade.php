
<div class="modal fade" id="modal_responsibles">
	<div class="modal-dialog" style="min-width: 1100px;">
		<div class="modal-content">
			<form role="form" method="POST" onsubmit="Main.sendFormDataReferences(event, $(this), window.LaravelDataTables['dtListResponsibles']);" action="{{ route('incoming_document_users.save_responsible', $incomingDocument->id) }}" >
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Ответственные</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@include('crm.incoming_documents.modal_users_body')
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->