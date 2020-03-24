<?php
namespace App\Services;

use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Builder as BuilderDT;

class BaseService
{

	protected $model;
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
				'name' => 'id',
			],
			[
				'title' => __($this->translation . 'list_columns.name'),
				'data' => 'name',
				'name' => 'name',
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
	public function constructViewDT() 
	{
		return app(BuilderDT::class)
				->language('//cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json')
				->columns( $this->tableColumns() );
	}
	
	/**
	 * Формирует данные для шаблона "Список элементов"
	 */
	public function dataTableData()
	{
		$query = $this->model
					->select( $this->columnsToSelect( $this->tableColumns() ) );
		
		return Datatables::of($query)
				->addColumn('action', function ($element){
					$routeName = $this->routeName;
					
					return view('crm.action_buttons', compact('element', 'routeName'));
				})
				->make(true);
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
					$resultArray[] = $value['data'];
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
	public function getElementData($element = null) 
	{
		return compact('element');
	}
	
}