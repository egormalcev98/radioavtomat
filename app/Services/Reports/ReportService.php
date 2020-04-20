<?php

namespace App\Services\Reports;

use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\IncomingDocuments\IncomingDocumentUser;
use App\Models\OutgoingDocuments\OutgoingDocument;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportService
{	
	public $templatePath = 'crm.reports.';
	
	public $templateForm = 'index';
	
	public $routeName = 'reports';
	
	public $translation = 'reports.';
	
	public $permissionKey = 'reports';
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$dateFromTo = now()->subWeek()->format('d.m.Y') . ' - ' . now()->format('d.m.Y');
		
		if(request()->period) {
			$dateFromTo = request()->period;
		}
		
		if(!request()->type_report or request()->type_report == 'incoming_docs') {
			$typeReport = 'incoming_docs';
			$data = $this->getIncomingDocs($dateFromTo);
			$columns = $this->getIncomingDocColumns();
		}
		
		if(request()->type_report == 'outgoing_docs') {
			$typeReport = 'outgoing_docs';
			$data = $this->getOutgoingDocs($dateFromTo);
			$columns = $this->getOutgoingDocColumns();
		}
		
		if(request()->type_report == 'signed_docs') {
			$typeReport = 'signed_docs';
			$data = $this->getSignedDocs($dateFromTo);
			$columns = $this->getSignedDocColumns();
		}
		
		if(request()->xlsx == 1) {
			return $this->generateExcelFile($data, $columns);
		} else {
			$data = $data->limit(1000)->get();
		}
		
		return compact('dateFromTo', 'data', 'columns', 'typeReport');
	}
	
    /**
     * Разбиваем временной интервал из daterangepicker на ключи массива
     */
    protected function dateRange($period)
    {
        if(isset($period) and $period){
            $dates = explode(' - ', $period);
            if(isset($dates[1])){
                $dates[0] = Carbon::parse($dates[0]);
                $dates[1] = Carbon::parse($dates[1])->endOfDay();
                return $dates;
            }
        }

        return [];
    }

	/**
	 * Получим колонки таблицы для входящих документов
	 */
	private function getIncomingDocColumns()
	{
		return [
			'number'					=> [
				'title' => __($this->translation . 'inc_docs.number'),
				'appeal' => 'number',
			],
			'date_delivery_at'	 		=> [
				'title' => __($this->translation . 'inc_docs.date_delivery_at'),
				'appeal' => 'date_delivery_at',
			],
			'incoming_doc_status_id'	=> [
				'title' => __($this->translation . 'inc_docs.incoming_doc_status'),
				'appeal' => [ 
					'relation' => 'status', 
					'attribute' => 'name'
				],
			],
		];
	}
	
	
	/**
	 * Получим отчет по входящим документам
	 */
	private function getIncomingDocs($dateFromTo)
	{
		return IncomingDocument::select(array_keys($this->getIncomingDocColumns()))
				->with('status')
				->whereBetween('date_delivery_at', $this->dateRange($dateFromTo))
				->orderBy('number');
	}
	
	/**
	 * Получим колонки таблицы для исходящих документов
	 */
	private function getOutgoingDocColumns()
	{
		return [
			'number'					=> [ 
				'title' => __($this->translation . 'out_docs.number'),
				'appeal' => 'number',
			],
			'date'	 					=> [
				'title' => __($this->translation . 'out_docs.date_delivery_at'),
				'appeal' => 'date',
			],
			'outgoing_doc_status_id'	=> [
				'title' => __($this->translation . 'out_docs.incoming_doc_status'),
				'appeal' => [
					'relation' => 'outgoingDocStatus', 
					'attribute' => 'name'
				],
			],
		];
	}
	
	/**
	 * Получим отчет по исходящим документам
	 */
	private function getOutgoingDocs($dateFromTo)
	{
		return OutgoingDocument::select(array_keys($this->getOutgoingDocColumns()))
				->with('outgoingDocStatus')
				->whereBetween('date', $this->dateRange($dateFromTo))
				->orderBy('number');
	}
	
	/**
	 * Получим колонки таблицы для исходящих документов
	 */
	private function getSignedDocColumns()
	{
		return [
			'number'					=> [
				'title' => __($this->translation . 'signed_docs.number'),
				'appeal' => 'number',
			],
			'user_created_at'	 		=> [
				'title' => __($this->translation . 'signed_docs.date_signed'),
				'appeal' => 'user_created_at',
			],
			'incoming_doc_status_id'	=> [
				'title' => __($this->translation . 'signed_docs.incoming_doc_status'),
				'appeal' => [ 
					'relation' => 'status', 
					'attribute' => 'name',
				],
			],
		];
	}
	
	/**
	 * Получим отчет по исходящим документам
	 */
	private function getSignedDocs($dateFromTo)
	{
		$docUser = IncomingDocumentUser::orderBy('created_at');
		
		$mainTable = app(IncomingDocument::class)->getTable();
		
		return IncomingDocument::select([
					$mainTable . '.number',
					$mainTable . '.incoming_doc_status_id',
					DB::raw('DATE_FORMAT(MIN(doc_users.created_at), "%d.%m.%Y %H:%i") AS user_created_at'),
				])
				->with('status')
				->joinSub($docUser, 'doc_users', function ($join) use($mainTable) {
					$join->on($mainTable . '.id', '=', 'doc_users.incoming_document_id');
				})
				->whereBetween('doc_users.created_at', $this->dateRange($dateFromTo))
				->groupBy($mainTable . '.id')
				->orderBy($mainTable . '.number');
	}
	
	/**
	 * Сгенерируем эксель файл по нужному отчету
	 */
	private function generateExcelFile($data, $columns)
	{
		$headings = [];
		$appeals = [];
		
		foreach($columns as $key => $column) {
			$headings[$key] = $column['title'];
			$appeals[$key] = $column['appeal'];
		}
		
		return Excel::download(new ReportsExport($data->get(), $headings, $appeals), 'report.xlsx');
	}
	
}