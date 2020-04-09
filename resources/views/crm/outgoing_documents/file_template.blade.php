	<td>
		@if(isset($dataFile))
			<a href="{{ Storage::url($dataFile->file_path) }}" target="_blank">{{ $dataFile->name }}</a>
		@endif
	</td>
	<td>
		<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Загрузить" >
			<input style="display: none;" @if(isset($dataFile)) name="scan_files[{{ $dataFile->id }}]" @else name="new_scan_files[]" @endif type="file" id="{{ isset( $dataFile) ? 'scan_input' . $dataFile->id : '' }}" onchange="OutgoingDocument.getFileName(this);" {{--accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/vnd.wap.wbmp,image/jpeg"--}} >
			@if(isset($dataFile))
				<input style="display: none;" type="hidden" name="isset_sf[{{ $dataFile->id }}]" value="{{ $dataFile->name }}">
			@endif
			<label style="cursor: pointer;" for="{{ isset( $dataFile) ? 'scan_input' . $dataFile->id : '' }}"><i class="fas fa-cloud-upload-alt"></i></label>
		</a>
		<a @if(!isset($dataFile)) style="display: none;" @endif href="{{ isset( $dataFile) ? Storage::url($dataFile->file_path) : 'javascript:void(0);' }}" data-toggle="tooltip" data-placement="top" title="Скачать" download>
			<i class="fas fa-cloud-download-alt"></i>
		</a>
		<a @if(!isset($dataFile)) style="display: none;" @endif href="javascript:void(0);" @if(isset($dataFile)) onclick="OutgoingDocument.showFileNameModal('{{ $dataFile->name }}', {{ $dataFile->id }});" @endif >
			<i class="fas fa-edit"></i>
		</a>
		<a onclick="OutgoingDocument.destroyTrScan($(this));" href="javascript:void(0);">
			<i class="fas fa-times-circle"></i>
		</a>
	</td>
