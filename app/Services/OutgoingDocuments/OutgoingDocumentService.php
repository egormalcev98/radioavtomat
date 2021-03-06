<?php

namespace App\Services\OutgoingDocuments;

use App\Exports\OutgoingDocumentExport;
use App\Models\OutgoingDocuments\OutgoingDocument;
use App\Models\OutgoingDocuments\OutgoingDocumentFile;
use App\Models\References\DocumentType;
use App\Models\References\LetterForm;
use App\Models\References\OutgoingDocStatus;
use App\Models\References\StructuralUnit;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Html\Builder as BuilderDT;
use App\Role;
use App\Services\BaseService;
use App\User;
use Carbon\Carbon;
use DataTables;

class OutgoingDocumentService extends BaseService
{
    public $templatePath = 'crm.outgoing_documents.';

    public $templateForm = 'form';

    public $routeName = 'outgoing_documents';

    public $translation = 'outgoing_documents.';

    public $permissionKey = 'outgoing_document'; // потом заменить на outgoing_document

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
        $outgoingDocStatuses = OutgoingDocStatus::select('id', 'name')->get();

        return compact('routeName', 'documentTypes', 'outgoingDocStatuses');
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
                'data' => 'document_type_name',
                'name' => 'document_type_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.from_user'),
                'data' => 'from_user',
                'name' => 'from_user_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.note'),
                'data' => 'note',
            ],
            [
                'title' => __($this->translation . 'list_columns.outgoing_doc_status'),
                'data' => 'outgoing_doc_status_name',
                'name' => 'outgoing_doc_status_id',
            ],

            $this->actionButton()
        ];
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function constructQueryDT($limit = null)
    {
        $select = $this->columnsToSelect($this->tableColumns());

        $query = $this->model
            ->select($select)
            ->with([
                'documentType',
                'fromUser',
                'outgoingDocStatus'
            ]);

        if ($limit) {
            $query->limit($limit);
        }

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

        if (request()->has('outgoing_doc_status') and request()->outgoing_doc_status) {
            $query->where('outgoing_doc_status_id', request()->outgoing_doc_status);
        }

        //////////////////

        return Datatables::of($query)
            ->addColumn('action', function ($element) {
                $routeName = $this->routeName;
                $element->name = $element->number; // так как в кнопках подставляется поле name

                return view('crm.action_buttons', compact('element', 'routeName'));
            })
            ->addColumn('showUrl', function ($element) {
                return route($this->routeName . '.show', $element->id);
            })
            ->addColumn('document_type_name', function ($element) {
                if ($element->documentType) {
                    return $element->documentType->name;
                }
                return '';
            })
            ->addColumn('from_user', function ($element) {
                if ($element->fromUser) {
                    return $element->fromUser->surnameWithInitials;
                }
                return '';
            })
            ->addColumn('outgoing_doc_status_name', function ($element) {
                if ($element->outgoingDocStatus) {
                    return $element->outgoingDocStatus->name;
                }
                return '';
            })
            ->filterColumn('document_type_id', function ($query, $keyword) {
                return $query->whereHas('documentType', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('from_user_id', function ($query, $keyword) {
                return $query->whereHas('fromUser', function ($query) use ($keyword) {
                    return $query->where('surname', 'like', '%' . $keyword . '%');
                });
            });
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function dataTableData()
    {
        return $this->constructQueryDT()->make(true);
    }

    /**
     * //
     * *Собираем объект DataTable для фронта
     * //
     *
     */
    public function constructViewDT($selectorForm = '#dt_filters')
    {
        $dt = parent::constructViewDT($selectorForm);

        $dt = $dt->scrollX(true);

        return $dt;

//        return app(BuilderDT::class)
//            ->language(config('datatables.lang'))
//            ->orders([0, 'desc'])
//            ->pageLength(25)
//            ->dom('<"row"<"col-2"l><"col-8"B><"col-2"f>>rt<"row"<"col-10"i><"col-2"p>>')
//            ->buttons('csv', 'excel')
//            ->ajaxWithForm('', $selectorForm)
//            ->columns($this->tableColumns());
    }

    /**
     * Создание записи в БД
     */
    public function store($request)
    {
        $requestAll = $request->all();
        $requestAll['date'] = $requestAll['date_letter_at'];
        $this->model = $this->model->create($requestAll);

        $this->furtherPreparation($requestAll);

        return true;
    }

    /**
     * Обновление записи в БД
     */
    public function update($request)
    {
        $requestAll = $request->all();

        $requestAll['date'] = $requestAll['date_letter_at'];

        $this->model->update($requestAll);

        $this->furtherPreparation($requestAll);

        return true;
    }


    private function furtherPreparation($requestAll)
    {
        $notDestroyFiles = [];

        if (isset($requestAll['new_scan_files']) and !empty($requestAll['new_scan_files'])) {
            foreach ($requestAll['new_scan_files'] as $newFile) {
                $originalName = $newFile->getClientOriginalName();
                $fileSave = $newFile->storeAs('outgoing_documents', $originalName, 'public');

                $notDestroyFiles[] = $this->model->files()->create([
                    'name' => $originalName,
                    'file_path' => $fileSave,
                ])->id;
            }
        }

        if (isset($requestAll['isset_sf']) and !empty($requestAll['isset_sf'])) {
            $getFiles = $this->model
                ->files()
                ->whereIn('id', array_flip($requestAll['isset_sf']))
                ->get();

            foreach ($getFiles as $file) {
                $notDestroyFiles[] = $file->id;

                if (isset($requestAll['scan_files']) and isset($requestAll['scan_files'][$file->id])) {
                    $replaceFile = $requestAll['scan_files'][$file->id];
                    $replaceFileSave = $replaceFile->store('outgoing_documents', 'public');

                    $file->update([
                        'name' => $replaceFile->getClientOriginalName(),
                        'file_path' => $replaceFileSave,
                    ]);
                } else {

                    if ($file->name != $requestAll['isset_sf'][$file->id]) {
                        $file->update([
                            'name' => $requestAll['isset_sf'][$file->id]
                        ]);
                    }
                }
            }
        }

        if (empty($notDestroyFiles)) {
            $files = $this->model
                ->files;
        } else {
            $files = $this->model
                ->files()
                ->whereNotIn('id', $notDestroyFiles)
                ->get();
        }
        foreach ($files as $file) {
            $file->delete();
        }

        return true;
    }

    /**
     * Данные для работы с элементом
     */
    public function elementData()
    {
        if ($this->model instanceof OutgoingDocument) {
            $outgoingDocument = $this->model;
            $outgoingDocumentFiles = $outgoingDocument->files()->orderedGet();
        } else {
            $outgoingDocument = new OutgoingDocument;
        }

        $letterForms = LetterForm::orderedGet();
        $outgoingDocStatuses = OutgoingDocStatus::orderedGet();
        $documentTypes = DocumentType::orderedGet();

        $userService = resolve('App\Services\Settings\UserService');
        $structuralUnits = $userService->getStructuredUsers();

        return compact('outgoingDocument', 'letterForms', 'outgoingDocStatuses', 'documentTypes', 'structuralUnits', 'outgoingDocumentFiles');
    }

    /**
     * Сформируем excel документ с даными из списка элементов
     */
    public function printExcel()
    {
        $columns = $this->columnUsedKeys($this->tableColumns());

        $arrayQueryDT = $this->constructQueryDT(200)->skipPaging()->toArray();

        $data = $this->collectDataExcel($arrayQueryDT['data'], $columns);

        return Excel::download(new OutgoingDocumentExport($data, array_values($columns)), 'data.xlsx');
    }

}
