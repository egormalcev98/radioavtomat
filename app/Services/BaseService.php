<?php
namespace App\Services;

use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Builder as BuilderDT;
use Carbon\Carbon;

class BaseService
{

    public $model;
    protected $translation;

    /**
     * Service constructor.
     * @param Builder $model
     */
    public function __construct(Builder $model)
    {
        $this->model = $model;
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
                'title' => __($this->translation . 'list_columns.name'),
                'data' => 'name',
            ],

            $this->actionButton()
        ];
    }

    /**
     * Стандартная кнопка действия для DataTable
     */
    protected function actionButton()
    {
        return [
            'title' => __('references.main.action_column'),
            'remove_select' => true,
            'width' => '60',
            'data' => 'action',
            'searchable' => false,
            'orderable' => false,
        ];
    }

    /**
     * Собираем объект DataTable для фронта
     */
    public function constructViewDT($selectorForm = '#dt_filters')
    {
        return app(BuilderDT::class)
            ->language(config('datatables.lang'))
            ->orders([0, 'desc'])
            ->pageLength(25)
            ->ajaxWithForm('', $selectorForm)
            ->columns( $this->tableColumns() );
    }

    /**
     * Сформируем колонку "Действие" для DataTable
     */
    protected function actionColumnDT()
    {
        return function ($element){
            $routeName = $this->routeName;

            return view('crm.action_buttons', compact('element', 'routeName'));
        };
    }

    /**
     * Собираем запрос и формируем коллекцию DT
     */
    protected function constructDataTableQuery()
    {
        $query = $this->model
            ->select( $this->columnsToSelect( $this->tableColumns() ) );

        return Datatables::of($query)
            ->addColumn('action', $this->actionColumnDT());
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function dataTableData()
    {
        return $this->constructDataTableQuery()->make(true);
    }

    /**
     * Получаем только заголовки колонок для DT
     */
    protected function columnsToSelect($array)
    {
        if(!empty($array)){
            $resultArray = [];

            foreach($array as $value){
                if(!isset($value['remove_select']) or $value['remove_select'] !== true) {
                    if(isset($value['name'])) {
                        $resultArray[] = $value['name'];
                    } else {
                        $resultArray[] = $value['data'];
                    }
                }
            }

            return $resultArray;
        }

        return $array;
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function outputData()
    {
        return [];
    }

    /**
     * Данные для работы с элементом
     */
    public function elementData()
    {
        if(class_basename($this->model) != 'Builder')
            $element = $this->model;

        return compact('element');
    }

    /**
     * Создание записи в БД
     */
    public function store($request)
    {
        $requestAll = $request->all();

        $this->model->create($requestAll);

        return true;
    }

    /**
     * Обновление записи в БД
     */
    public function update($request)
    {
        $requestAll = $request->all();

        $this->model->update($requestAll);

        return true;
    }

    /**
     * Удаляем элемент
     */
    public function removeElement()
    {
        return $this->model->delete();
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
     * Получаем только ключи колонок DT
     */
    protected function columnUsedKeys($array)
    {
        if(!empty($array)){
            $resultArray = [];

            foreach($array as $value){
                if($value['data'] !== 'action')
                    $resultArray[$value['data']] = $value['title'];
            }

            return $resultArray;
        }

        return $array;
    }

    /**
     * Собираем данные для Excel, отсортируем для соответсвия шапке и уберем лишние колонки, которых нет в шапке
     */
    protected function collectDataExcel($data, $columns)
    {
        $sColumns = array_flip(array_keys($columns));

        if(!empty($data)) {
            foreach($data as $key => $value) {
                $newArray = array_intersect_key($value, $columns);

                uksort($newArray, function ($a, $b) use($sColumns) {

                    return $sColumns[$a] > $sColumns[$b];
                });

                $data[$key] = $newArray;
            }
        }

        return $data;
    }
}
