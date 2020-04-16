<?php

namespace App\Services\IncomingDocuments;

use App\Services\BaseService;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\IncomingDocStatus;
use App\Models\References\DocumentType;
use App\Models\References\EmployeeTask;
use App\User;
use DataTables;
use App\Services\IncomingDocuments\IncomingUserService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomingDocumentExport;

class IncomingDocumentService extends BaseService
{
    public $templatePath = 'crm.incoming_documents.';

    public $templateForm = 'form';

    public $routeName = 'incoming_documents';

    public $translation = 'incoming_documents.';

    public $permissionKey = 'incoming_document';

    protected $incomingUserService;

    public function __construct(IncomingUserService $incomingUserService)
    {
        parent::__construct(IncomingDocument::query());

        $this->incomingUserService = $incomingUserService;
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function outputData()
    {
        $documentTypes = DocumentType::orderedGet();
        $incomingDocStatuses = IncomingDocStatus::orderedGet();

        return compact('documentTypes', 'incomingDocStatuses');
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
                'title' => __($this->translation . 'list_columns.created_at'),
                'data' => 'created_at',
            ],
            [
                'title' => __($this->translation . 'list_columns.title'),
                'data' => 'title',
            ],
            [
                'title' => __($this->translation . 'list_columns.counterparty'),
                'data' => 'counterparty',
            ],
            [
                'title' => __($this->translation . 'list_columns.number'),
                'data' => 'number',
            ],
            [
                'title' => __($this->translation . 'list_columns.date_letter_at'),
                'data' => 'date_letter_at',
            ],
            [
                'title' => __($this->translation . 'list_columns.document_type'),
                'data' => 'document_type_name',
                'name' => 'document_type_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.who_painted'),
                'data' => 'who_painted',
                'remove_select' => true,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => __($this->translation . 'list_columns.date_painted'),
                'data' => 'date_painted',
                'remove_select' => true,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => __($this->translation . 'list_columns.whom_distributed'),
                'data' => 'whom_distributed',
                'remove_select' => true,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => __($this->translation . 'list_columns.responsibles'),
                'data' => 'list_responsibles',
                'remove_select' => true,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => __($this->translation . 'list_columns.note'),
                'data' => 'note',
            ],
            [
                'title' => __($this->translation . 'list_columns.percentage_consideration'),
                'data' => 'percentage_consideration',
                'remove_select' => true,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'title' => __($this->translation . 'list_columns.status_name'),
                'data' => 'status_name',
                'name' => 'incoming_doc_status_id',
            ],

            $this->actionButton()
        ];
    }

    private function constructQueryDT($limit = null)
    {
        $select = $this->columnsToSelect( $this->tableColumns() );
        $select[] = 'urgent';

        $query = $this->model
            ->select( $select )
            ->with([
                'documentType',
                'users.user',
                'users',
                'distributed',
                'distributed.user',
                'responsibles',
                'responsibles.user',
                'status',
            ]);

        if($limit) {
            $query->limit($limit);
        }

        // Фильтры

        if(isset(request()->period)){
            $query->whereBetween('created_at', $this->dateRange(request()->period));
        }

        if (request()->has('document_type_id') and request()->document_type_id) {
            $query->where('document_type_id', request()->document_type_id);
        }

        if (request()->has('incoming_doc_status_id') and request()->incoming_doc_status_id) {
            $query->where('incoming_doc_status_id', request()->incoming_doc_status_id);
        }

        //////////////////

        return Datatables::of($query)
            ->addColumn('action', $this->actionColumnDT())
            ->addColumn('showUrl', function ($element) {
                return route($this->routeName . '.show', $element->id);
            })
            ->addColumn('who_painted', function ($element) {
                if($element->users->isNotEmpty()) {
                    return $element->users
                        ->whereNotNull('signed_at')
                        ->groupBy('user_id')
                        ->map(function($user) {

                            return $user->first()->user->fullName;
                        })->implode(', ');
                }
                return '';
            })
            ->addColumn('date_painted', function ($element) {
                if($element->users->isNotEmpty()) {
                    $lastSigned = $element->users
                        ->whereNotNull('signed_at')
                        ->sortByDesc('signed_at')
                        ->first();
                    if($lastSigned) {
                        return $lastSigned->someSignedAt;
                    }
                }
                return '';
            })
            ->addColumn('whom_distributed', function ($element) {
                if($element->distributed->isNotEmpty()) {
                    return $element->distributed->map(function($distr) {

                        return $distr->user->fullName;
                    })->implode(', ');
                }
                return '';
            })
            ->addColumn('list_responsibles', function ($element) {
                if($element->responsibles->isNotEmpty()) {
                    return $element->responsibles->map(function($distr) {

                        return $distr->user->fullName;
                    })->implode(', ');
                }
                return '';
            })
            ->addColumn('percentage_consideration', function ($element) {
                $countUsers = $element->users->count();
                $countUsersNotNullSigned = $element->users->whereNotNull('signed_at')->count();

                return ($countUsers > 0) ? (( $countUsersNotNullSigned / $countUsers ) * 100) : 0 ;
            })
            ->addColumn('status_name', function ($element) { // для экселя эти жертвы
                return $element->status->name;
            })
            ->addColumn('document_type_name', function ($element) {
                return $element->documentType->name;
            })
            ->removeColumn('users')
            ->removeColumn('distributed')
            ->removeColumn('responsibles')
            ->removeColumn('document_type')
            ->removeColumn('status');
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function dataTableData()
    {
        return $this->constructQueryDT()->make(true);
    }
    /**
     * Собираем объект DataTable для фронта
     */
    public function constructViewDT($selectorForm = '#dt_filters')
    {
        $dt = parent::constructViewDT($selectorForm);

        return $dt->scrollX(true);
    }

    /**
     * Данные для работы с элементом
     */
    public function elementData()
    {
        $incomingDocStatuses = IncomingDocStatus::orderedGet();
        $documentTypes = DocumentType::orderedGet();
        $recipients = User::withoutAdmin()->get();

        if(class_basename($this->model) != 'Builder') {
            $incomingDocument = $this->model;
            $incomingDocumentFiles = $this->model->files()->orderedGet();

            $editDistributed = $this->incomingUserService->checkEditDistributed($this->model->id);
            $editResponsibles = $this->incomingUserService->checkEditResponsibles($this->model->id);

            $datatableDistributed = $this->incomingUserService->constructViewDTDistributed($this->model->id);
            $datatableResponsibles = $this->incomingUserService->constructViewDTResponsibles($this->model->id);

            $employees = $recipients;
            $employeeTasks = EmployeeTask::orderedGet();

            $signatureUser = $this->incomingUserService->checkSignatureUsers($incomingDocument);

            $signedUser = $this->model->users()->whereNotNull('signed_at')->authElements()->first() ??
                $this->model->users()->whereNotNull('reject_at')->authElements()->first() ??
                null;

            $reconciliationSections = $this->model
                ->users()
                ->with(['user'])
                ->groupBy('user_id')
                ->get();
        }

        return compact(
            'incomingDocument',
            'incomingDocStatuses',
            'documentTypes',
            'recipients',
            'incomingDocumentFiles',
            'editDistributed',
            'editResponsibles',
            'datatableDistributed',
            'datatableResponsibles',
            'employees',
            'employeeTasks',
            'signatureUser',
            'signedUser',
            'reconciliationSections'
        );
    }

    /**
     * Создание записи в БД
     */
    public function store($request)
    {
        $requestAll = $request->all();

        $requestAll = $this->preliminaryPreparation($requestAll);

        if(isset($requestAll['register_automatic'])) {
            $lastDoc = IncomingDocument::latest()->first();
            $requestAll['register'] = $lastDoc ? ($lastDoc->register + 1) : 1;
        }

        $this->model = $this->model->create($requestAll);

        $this->furtherPreparation($requestAll);

        return true;
    }

    private function preliminaryPreparation($requestAll)
    {
        if(isset($requestAll['urgent'])) {
            $requestAll['urgent'] = 1;
        } else {
            $requestAll['urgent'] = null;
        }

        if(isset($requestAll['original_received'])) {
            $requestAll['original_received'] = 1;
        } else {
            $requestAll['original_received'] = null;
        }

        return $requestAll;
    }

    private function furtherPreparation($requestAll)
    {
        $notDestroyFiles = [];

        if(isset($requestAll['new_scan_files']) and !empty($requestAll['new_scan_files'])) {
            foreach($requestAll['new_scan_files'] as $newFile) {
                $fileSave = $newFile->store('incoming_documents', 'public');

                $notDestroyFiles[] = $this->model->files()->create([
                    'name' => $newFile->getClientOriginalName(),
                    'file_path' => $fileSave,
                ])->id;
            }
        }

        if(isset($requestAll['isset_sf']) and !empty($requestAll['isset_sf'])) {
            $getFiles = $this->model
                ->files()
                ->whereIn('id', array_flip($requestAll['isset_sf']))
                ->get();

            foreach($getFiles as $file) {
                $notDestroyFiles[] = $file->id;

                if(isset($requestAll['scan_files']) and isset($requestAll['scan_files'][$file->id])) {
                    $replaceFile = $requestAll['scan_files'][$file->id];
                    $replaceFileSave = $replaceFile->store('incoming_documents', 'public');

                    $file->update([
                        'name' => $replaceFile->getClientOriginalName(),
                        'file_path' => $replaceFileSave,
                    ]);
                } else {

                    if($file->name != $requestAll['isset_sf'][$file->id]) {
                        $file->update([
                            'name' => $requestAll['isset_sf'][$file->id]
                        ]);
                    }
                }
            }
        }

        if(empty($notDestroyFiles)) {
            $this->model
                ->files()
                ->delete();
        } else {
            $this->model
                ->files()
                ->whereNotIn('id', $notDestroyFiles)
                ->delete();
        }

        return true;
    }

    /**
     * Обновление записи в БД
     */
    public function update($request)
    {
        $requestAll = $request->all();

        $requestAll = $this->preliminaryPreparation($requestAll);

        $this->model->update($requestAll);

        $this->furtherPreparation($requestAll);

        return true;
    }

    /**
     * Сформируем excel документ с даными из списка элементов
     */
    public function printExcel()
    {
        $columns = $this->columnUsedKeys($this->tableColumns());

        $arrayQueryDT = $this->constructQueryDT(200)->skipPaging()->toArray();

        $data = $this->collectDataExcel($arrayQueryDT['data'], $columns);

        return Excel::download(new IncomingDocumentExport($data, array_values($columns)), 'data.xlsx');
    }
}
