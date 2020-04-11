<?php

namespace App\Services\Activity;

use App\Models\Activity\ActivityLog;
use Yajra\DataTables\Html\Builder as BuilderDT;
use App\Services\BaseService;;
use DataTables;

class ActivityService extends BaseService
{
    public $templatePath = 'crm.activity.';

    public $templateForm = 'form';

    public $routeName = 'activity';

    public $translation = 'activity.';

    public $permissionKey = 'activity';

    public $model;

    public function __construct()
    {
        parent::__construct(ActivityLog::query());
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function outputData()
    {
        return [];
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
                'title' => __($this->translation . 'list_columns.description'),
                'data' => 'description',
            ],
            [
                'title' => __($this->translation . 'list_columns.created_at'),
                'data' => 'created_at',
            ],
        ];
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function dataTableData()
    {
        $select = $this->columnsToSelect($this->tableColumns());

        $query = $this->model
            ->select($select);

        // Фильтры

        //////////////////

        return Datatables::of($query)
            ->addColumn('description', function ($element) {
                return $element->descriptionSpan;
            })
            ->make(true);
    }

}
