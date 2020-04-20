@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<!-- /.card-header -->
				<div class="card-body">
					<form>
						<div class="col-12 row">
						
							<div class="col-3">
								<div class="form-group">
									<label>Период с/по</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
										<input type="text" class="form-control pull-right" id="period" name="period" autocomplete="off" value="{{ $dateFromTo }}" >
									</div>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label>Тип отчета</label>
									<select class="form-control select2" name="type_report">
										<option @if($typeReport == 'incoming_docs') selected @endif value="incoming_docs">Входящие документы</option>
										<option @if($typeReport == 'outgoing_docs') selected @endif value="outgoing_docs">Исходящие документы</option>
										<option @if($typeReport == 'signed_docs') selected @endif value="signed_docs">Переданы на подпись</option>
									</select>
								</div>
							</div>
							
							<div class="col-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-block btn-primary">Показать</button>
								</div>
							</div>
							<div class="col-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-block btn-info" name="xlsx" value="1" >Скачать</button>
								</div>
							</div>
							<div class="col-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-block btn-warning" onClick="javascript:CallPrint('print-content');" >Печать</button>
								</div>
							</div>
							
						</div>
					</form>
					
					<div class="p-0" id="print-content">
						@if(!empty($columns))
							<table class="table">
								<thead>
									<tr>
										@foreach($columns as $col)
											<th>{{ $col['title'] }}</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@if($data->isNotEmpty())
										@foreach($data as $element)
											<tr>
												@foreach($columns as $column)
													<td>{{ (is_array($column['appeal'])) ? $element->{$column['appeal']['relation']}->{$column['appeal']['attribute']} : $element->{$column['appeal']} }}</td>
												@endforeach
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						@endif
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
@stop

@section('js')
	<script type="text/javascript">
        $(document).ready(function(){
            $('#period').daterangepicker({
                'opens': 'right',
                'locale': Main.confDrp,
                'autoUpdateInput': false
            }, function(start_date, end_date) {
                this.element.val(start_date.format(Main.confDrp.format) + ' - ' + end_date.format(Main.confDrp.format)).change();
            });
        });
		
		function CallPrint(strid) {
			var prtContent = document.getElementById(strid);
			// var prtCSS = '<link rel="stylesheet" href="" type="text/css" />';
			var WinPrint = window.open('','','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
			WinPrint.document.write('<div id="print" class="contentpane">');
			// WinPrint.document.write(prtCSS);
			WinPrint.document.write(prtContent.innerHTML);
			WinPrint.document.write('</div>');
			WinPrint.document.close();
			WinPrint.focus();
			WinPrint.print();
			WinPrint.close();
			prtContent.innerHTML=strOldOne;
		}
    </script>
@stop