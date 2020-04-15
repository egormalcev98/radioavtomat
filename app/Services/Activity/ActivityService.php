<?php

namespace App\Services\Activity;

use App\Models\Activity\ActivityLog;
use App\Models\OutgoingDocuments\OutgoingDocument;
use App\Models\OutgoingDocuments\OutgoingDocumentFile;
use App\Models\References\DocumentType;
use App\Models\References\LetterForm;
use App\Models\References\OutgoingDocStatus;
use Carbon\Carbon;
use \Illuminate\Support\Facades\Cookie as Cookie;
use Yajra\DataTables\Html\Builder as BuilderDT;
use App\Services\BaseService;
use function Complex\theta;


class ActivityService extends BaseService
{
    public $templatePath = 'crm.activity.';

    public $routeName = 'activity';

    public $translation = 'activity.';

    public $permissionKey = 'activity';

    public $model;

    public $letterForms;
    public $outgoingDocStatuses;
    public $documentTypes;

    public $iconClasses = [
        'created' => 'fas fa-plus-circle',
        'deleted' => 'fas fa-minus-circle',
        'updated' => 'fas fa-pen',
        'download' => 'fas fa-uploaded',
        'uploaded' => 'fas fa-download',
    ];

    public $baseText = [
        'created' => 'создал документ.',
        'deleted' => 'удалил документ.',
        'updated' => 'отрадактировал документ:',
        'download' => 'скачал скан',
        'uploaded' => 'загрузил скан',
        'deleted_scan' => 'удалил скан',
        'rename_scan' => 'переименовал скан',
        'reload_scan' => 'перезалил скан',
    ];

    // для кнопок переключения
    public $filterWays = [
        'out' => [
            'App\Models\OutgoingDocuments\OutgoingDocument',
            'App\Models\OutgoingDocuments\OutgoingDocumentFile',
        ],
        'in' => [
            'App\Models\IncomingDocuments\IncomingDocument',
            'App\Models\IncomingDocumentsIncomingDocumentFile',
        ]
    ];

    public function __construct()
    {
        parent::__construct(ActivityLog::query());

        $this->letterForms = LetterForm::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $this->outgoingDocStatuses = OutgoingDocStatus::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $this->documentTypes = DocumentType::select('id', 'name')->get()->pluck('name', 'id')->toArray();
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function outputData()
    {
        return [];
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function tableData($request = [])
    {
        $raws = $this->model
            ->select(['*'])
            ->with([
                'outgoingDocument',
                'outgoingDocumentFile.outgoingDocument',
                'causer',
            ]);

        // Фильтры
        $keyword = null;
        $wayFilter = null;
        if ($request != []) {
            if ($request['search']) {
                $keyword = $request['search'];
                Cookie::queue(Cookie::make("activity_search", $keyword, 518400));
            } else {
                Cookie::queue(Cookie::forget("activity_search"));
            }
            if ($request['way']) {
                $wayFilter = $request['way'];
                Cookie::queue(Cookie::make("activity_way", $wayFilter, 518400));
            }
        } else {
            $keyword = Cookie::get('activity_search');
            $wayFilter = Cookie::get('activity_way');
        }

        if ($keyword) {
            $raws->whereHas('outgoingDocument', function ($query) use ($keyword) {
                return $query->where('number', 'like', '%' . $keyword . '%')
                    ->orWhere('title', 'like', '%' . $keyword . '%');
            })
                ->orWhereHas('outgoingDocumentFile.outgoingDocument', function ($query) use ($keyword) {
                    return $query->where('number', 'like', '%' . $keyword . '%')
                        ->orWhere('title', 'like', '%' . $keyword . '%');
                });
        }

            if ($wayFilter) {
                $raws->whereIn('subject_type', $this->filterWays[$wayFilter]);
            }


        $raws = $raws->paginate(10);

        $paginator = $raws->links();
        //->get();

        // собираем по датам
        $dateRaws = [];
        foreach ($raws as $raw) {
            $dateRaws[Carbon::parse($raw->created_at)->format('d.m.Y')][] = $raw;
        }

// собираем по ID документа и еще делим на входящие и исходящие и возможно другие какиенибуть
        $formatedDateRaws = [];
        foreach ($dateRaws as $dateRawKey => $raws) {
            foreach ($raws as $raw) {
                switch ($raw->subject_type) {
                    case 'App\Models\OutgoingDocuments\OutgoingDocument':
                        $formatedDateRaws[$dateRawKey]['out_' . $raw->subject_id][] = $raw;
                        break;
                    case 'App\Models\OutgoingDocuments\OutgoingDocumentFile':
                        // это чтобы учитывать что для разных методов (updated, created) Json строки могут отличаться, например при created отсутствует массив old
                        switch ($raw->description) {
                            case 'updated':
                                $outgoing_document_id = json_decode($raw->properties)->old->outgoing_document_id;
                                break;
                            case 'created':
                                $outgoing_document_id = json_decode($raw->properties)->attributes->outgoing_document_id;
                                break;
                        }
                        $formatedDateRaws[$dateRawKey]['out_' . $outgoing_document_id][] = $raw;
                        break;

                    // тут надо дописать правила группировки по ID документа для входящих документов через ключ например in_. или для каких то еще документов использую свой ключ

                    default:
                        $formatedDateRaws[$dateRawKey][$raw->subject_id][] = $raw; // по умолчанию группируем просто по ID модели которое написано в поле subject_id
                }
            }
        }

// и наконец обрабатываем список действий внутри документа для понятного вывода. для каждого типа (входящий, исходящий) своя функция, так как там есть разные поля
// функцию будем выбирать исходя из ключа который дописывали к id документа ранее. Для исходящих например это out_

        foreach ($formatedDateRaws as $dateRaws) {
            foreach ($dateRaws as $key => $raws) {
                $startKey = substr($key, 0, 3);
                switch ($startKey) {
                    case 'out':
                        $this->processingJsonOutgoingDocument($raws);
                        break;
                }
            }
        }

        return [$formatedDateRaws, $paginator];

    }

    public function prepareFormatingOutgoingDocumentTitle($iconClassDoc, $way, $raw)
    {
        return $this->formatingDocumenTitle($iconClassDoc, $way, $raw->outgoingDocument->title, $raw->outgoingDocument->number);
    }

    public function prepareFormatingOutgoingDocumentFileTitle($iconClassDoc, $way, $raw)
    {
        return $this->formatingDocumenTitle($iconClassDoc, $way, $raw->outgoingDocumentFile->outgoingDocument->title, $raw->outgoingDocumentFile->outgoingDocument->number);
    }

    public function formatingDocumenTitle($iconClassDoc, $way, $title, $number)
    {
        return view($this->templatePath . 'formated_title')
            ->with(compact('iconClassDoc', 'way', 'title', 'number'));
    }

    public function formatingDocumenProperties($iconClass, $name, $text, $old = false, $new = false, $properties = false, $time = '?')
    {
        return view($this->templatePath . 'formated_properties')
            ->with(compact('iconClass', 'name', 'text', 'old', 'new', 'properties', 'time'));
    }

    public function formatingtPropertiesOutgoingDocument($properties)
    {//letter_form_id
        $result = [];
        $properties = json_decode($properties);

        foreach ($properties->old as $key => $property) {
            switch ($key) {
                case 'letter_form_id':
                    $old = $this->letterForms[$property];
                    $new = $this->letterForms[$properties->attributes->$key];
                    break;
                case 'outgoing_doc_status_id':
                    $old = $this->outgoingDocStatuses[$property];
                    $new = $this->outgoingDocStatuses[$properties->attributes->$key];
                    break;
                case 'document_type_id':
                    $old = $this->documentTypes[$property];
                    $new = $this->documentTypes[$properties->attributes->$key];
                    break;
                default:
                    $old = $property;
                    $new = $properties->attributes->$key;
            }

            $result[] = [
                'caption' => __('validation.attributes.' . $key),
                'old' => $old,
                'new' => $new,
            ];

        }
        return $result;
    }

    public function preparePropertiesOutgoingDocumentFile($properties)
    {
        $action = $this->baseText['rename_scan'];

        $properties = json_decode($properties);

        if (isset($properties->old->file_path)) {
            $action = $this->baseText['reload_scan'];
        }

        $result = [
            'caption' => $action,
            'old' => $properties->old->name,
            'new' => $properties->attributes->name,
        ];

        return $result;

    }

    /**
     * Обработка Json исходящего документа
     */
    public function processingJsonOutgoingDocument($raws)
    {
        $way = 'Исходящий';
        $iconClassDoc = 'fas fa-file-upload ';

        foreach ($raws as $raw) {
            $name = $raw->causer->fullName;
            $time = Carbon::parse($raw->created_at)->format('H:i');
            switch ($raw->subject_type) {
                case 'App\Models\OutgoingDocuments\OutgoingDocument':
                    $raw->formatedTitle = $this->prepareFormatingOutgoingDocumentTitle($iconClassDoc, $way, $raw);
                    $iconClass = $this->iconClasses[$raw->description];
                    $text = $this->baseText[$raw->description];
                    $properties = false;
                    if ($raw->description == 'updated') {
                        $properties = $this->formatingtPropertiesOutgoingDocument($raw->properties);
                    }
                    $raw->formatedProperties = $this->formatingDocumenProperties($iconClass, $name, $text, false, false, $properties, $time);
                    break;
                case 'App\Models\OutgoingDocuments\OutgoingDocumentFile':
                    $raw->formatedTitle = $this->prepareFormatingOutgoingDocumentFileTitle($iconClassDoc, $way, $raw);
                    switch ($raw->description) {
                        case 'updated':
                            $description = $this->preparePropertiesOutgoingDocumentFile($raw->properties);
                            $raw->formatedProperties = $this->formatingDocumenProperties(
                                $this->iconClasses['updated'],
                                $name,
                                $description['caption'],
                                $description['old'],
                                $description['new'],
                                false,
                                $time
                            );
                            break;
                        case 'created':
                            $raw->formatedProperties = $this->formatingDocumenProperties(
                                $this->iconClasses['uploaded'],
                                $name,
                                $this->baseText['uploaded'],
                                json_decode($raw->properties)->attributes->name,
                                false,
                                false,
                                $time
                            );
                            break;
                        case 'deleted':
                            $raw->formatedProperties = $this->formatingDocumenProperties(
                                $this->iconClasses['deleted'],
                                $name,
                                $this->baseText['deleted_scan'],
                                json_decode($raw->properties)->attributes->name,
                                false,
                                false,
                                $time
                            );
                            break;
                    }
                    break;
                // тут для других
                default:
                    $raw->formatedTitle = 'Документ не найден';
                    $raw->formatedProperties = 'Действие не определено';
            }
        }
    }
}
