<?php

namespace App\Helpers;

trait ReferenceHelper
{
	/**
     * Действия при успешном создании элемента
     */
	public function successfulElementCreation($routeName)
	{
		flash(__('references.main.flash_success_create'))->success();
		
		return redirect()->route($routeName . '.index');
	}
	
	/**
     * Действия при успешном обновлении элемента
     */
	public function successfulElementUpdate($routeName, $elementId)
	{
		flash(__('references.main.flash_success_update'))->success();
		
		// return redirect()->route($routeName . '.edit', $elementId);
		return redirect()->route($routeName . '.index');
	}
	
	/**
     * Ответ сервера после удаления элемента
     */
	public function serverResponseDestroy()
	{
		return response()->json([
			'action' => 'reload_table'
		]);
	}

	public function serverErrorResponseDestroy($errorMessage)
	{
		return response()->json([
			'error' => $errorMessage
		]);
	}
	
	/**
     * Ссылка для кнопки отмена
     */
	public function cancelUrl($routeName)
	{
		return route($routeName . '.index');
	}
	
	/**
     * Успешный ответ сервера на ajax-запрос
     */
	public function ajaxSuccessResponse($msg = '')
	{
		return response()->json([
			'status' => 'success',
			'msg' => $msg,
		]);
	}
	
	/**
     * Неудачная обработка даных сервером ajax-запроса
     */
	public function ajaxFailedResponse($msg = '')
	{
		return response()->json([
			'status' => 'error',
			'msg' => $msg,
		]);
	}
	
}