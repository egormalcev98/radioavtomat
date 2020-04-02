
@hasSection('modal')
<div class="modal fade" id="@yield('modal_id')">
	<div class="modal-dialog" style="@yield('style')">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">@yield('modal_title')</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@yield('modal')
		</div>
		<!-- /.modal-content -->
	</div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif
