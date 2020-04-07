<?php

namespace App\Services\OutgoingDocuments;

use App\Models\OutgoingDocuments\OutgoingDocument;
use App\Models\References\DocumentType;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;

class OutgoingDocumentService extends BaseService
{
	public $templatePath = 'crm.outgoing_documents.';

	public $templateForm = 'form';

	public $routeName = 'outgoing_documents';

	public $translation = 'outgoing_documents.';

	public $permissionKey = 'user'; // потом заменить на outgoing_documents

    public $model;

	public function __construct()
    {
        parent::__construct(OutgoingDocument::query());
    }

	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function outputData()
	{
		$routeName = $this->routeName;
		$documentTypes = DocumentType::select('id', 'name')->get();

		return compact('routeName', 'documentTypes');
	}

    /**
     * Возвращает список всех колонок для DataTable
     */
    public function tableColumns()
    {
        return [
            [
                'title' => __($this->translation . 'list_columns.id'),
                'data' => 'id',
            ],
            [
                'title' => __($this->translation . 'list_columns.number'),
                'data' => 'number',
            ],
            [
                'title' => __($this->translation . 'list_columns.date'),
                'data' => 'date',
            ],
            [
                'title' => __($this->translation . 'list_columns.counterparty'),
                'data' => 'counterparty',
            ],
            [
                'title' => __($this->translation . 'list_columns.document_type'),
                'data' => 'document_type.name',
                'name' => 'document_type_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.from_user'),
                'data' => 'from_user.surnameWithInitials',
                'name' => 'from_user_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.note'),
                'data' => 'note',
            ],
            [
                'title' => __($this->translation . 'list_columns.outgoing_doc_status'),
                'data' => 'outgoing_doc_status.name',
                'name' => 'outgoing_doc_status_id',
            ],

            $this->actionButton()
        ];
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function dataTableData()
    {
        $select = $this->columnsToSelect( $this->tableColumns() );

        $query = $this->model
            ->select( $select )
            ->with([
                'documentType',
                'fromUser',
                'outgoingDocStatus'
            ]);

        // Фильтры

        if (request()->has('document_type') and request()->document_type) {
            $query->where('document_type_id', request()->document_type);
        }

        if (request()->has('period') and request()->period) {
            $dates = explode(' - ', request()->period);
            if (isset($dates[1])) {
                $periodStart = Carbon::parse($dates[0])->toDateString();
                $periodEnd = Carbon::parse($dates[1])->toDateString();
            }
            $query->whereBetween('date', [$periodStart, $periodEnd]);
        }

        //////////////////

        return Datatables::of($query)
            ->addColumn('action', function ($element){
                $routeName = $this->routeName;

                return view('crm.action_buttons', compact('element', 'routeName'));
            })
            ->addColumn('showUrl', function ($element) {
                return route($this->routeName . '.show', $element->id);
            })
            ->filterColumn('document_type_id', function($query, $keyword) {
                return $query->whereHas('documentType', function($query) use($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('from_user_id', function($query, $keyword) {
                return $query->whereHas('fromUser', function($query) use($keyword) {
                    return $query->where('surname', 'like', '%' . $keyword . '%');
                });
            })
            ->make(true);
    }

    /**
     * Данные для работы с элементом
     */
    public function elementData()
    {
        $outgoingDocument = $this->model;
//        $userStatuses = UserStatus::orderedGet();
//        $structuralUnits = StructuralUnit::orderedGet();
//        $roles = Role::withoutAdmin()->get();

        return compact('outgoingDocument');
    }

}
