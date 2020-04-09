<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\ReferenceHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ReferenceHelper;

	protected $service;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if (request()->ajax()) {
			return $this->service->dataTableData();
		}

		$with = $this->service->outputData();

		$with['title'] = __($this->service->translation . 'index.title');
		$with['datatable'] = $this->service->constructViewDT();
		$with['createLink'] = route($this->service->routeName . '.create');

		return view($this->service->templatePath . 'listelements')->with($with);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$with = $this->service->elementData();

		$with['title'] = __($this->service->translation . 'index.title') . ': ' . __('references.main.create_text_template');
		$with['action'] = route($this->service->routeName . '.store');
		$with['method'] = __FUNCTION__;

		return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeElement($request)
    {
        $this->service->store($request);

		return $this->successfulElementCreation($this->service->routeName);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function ajaxStoreElement($request)
    {
        if ($request->ajax()) {

			$this->service->store($request);

			return $this->ajaxSuccessResponse();
		}

		return abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function showElement($element)
    {
		$this->service->model = $element;
        $with = $this->service->elementData();

		$with['title'] = __($this->service->translation . 'index.title') . ': ' . __('references.main.show_text_template');
		$with['method'] = 'edit';

		return view($this->service->templatePath . 'show')->with($with);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function editElement($element)
    {
		$this->service->model = $element;
        $with = $this->service->elementData();

		$with['title'] = __($this->service->translation . 'index.title') . ': ' . __('references.main.edit_text_template');
		$with['action'] = route($this->service->routeName . '.update', $element->id);
		$with['method'] = 'edit';

		return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function updateElement($request, $element)
    {
		$this->service->model = $element;
        $this->service->update($request);

		return $this->successfulElementUpdate($this->service->routeName, $element->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function ajaxUpdateElement($request, $element)
    {
		if ($request->ajax()) {
			$this->service->model = $element;
			$this->service->update($request);

			return $this->ajaxSuccessResponse();
		}

		return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function destroyElement($element)
    {
		if (request()->ajax()) {
			$this->service->model = $element;
			$this->service->removeElement();

			return $this->serverResponseDestroy();
		}

		return abort(403);
    }
}
