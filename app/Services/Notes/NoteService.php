<?php

namespace App\Services\Notes;

use App\Models\Notes\Note;
use App\Models\Notes\NoteFile;
use App\Models\References\CategoryNote;
use App\Models\References\StatusNote;

use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;

class NoteService extends BaseService
{
    public $templatePath = 'crm.notes.';

    public $templateForm = 'form';

    public $routeName = 'notes';

    public $translation = 'notes.';

    public $permissionKey = 'note';

    public $model;

    public function __construct()
    {
        parent::__construct(Note::query());
    }

    /**
     * Формирует данные для шаблона "Список элементов"
     */
    public function outputData()
    {
        $routeName = $this->routeName;
        $categoryNotes = CategoryNote::select('id', 'name')->get();
        $statusNotes = StatusNote::select('id', 'name')->get();

        return compact('routeName', 'categoryNotes', 'statusNotes');
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
                'title' => __($this->translation . 'list_columns.created_at'),
                'data' => 'created_at',
            ],
            [
                'title' => __($this->translation . 'list_columns.category_note'),
                'data' => 'category_note',
                'name' => 'category_note_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.creator'),
                'data' => 'creator',
                'name' => 'creator_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.user'),
                'data' => 'user',
                'name' => 'user_id',
            ],
            [
                'title' => __($this->translation . 'list_columns.title'),
                'data' => 'title',
            ],
            [
                'title' => __($this->translation . 'list_columns.text'),
                'data' => 'text',
                'width' => 300,
            ],
            [
                'title' => __($this->translation . 'list_columns.status_note'),
                'data' => 'status_note',
                'name' => 'status_note_id',
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
                'user',
                'creator',
                'categoryNote',
                'statusNote',
            ]);

        if ($limit) {
            $query->limit($limit);
        }

        // Фильтры

        if (request()->has('category_note_id') and request()->category_note_id) {
            $query->where('category_note_id', request()->category_note_id);
        }

        if (request()->has('status_note_id') and request()->status_note_id) {
            $query->where('status_note_id', request()->status_note_id);
        }

        if (request()->has('period') and request()->period) {
            $dates = explode(' - ', request()->period);
            if (isset($dates[1])) {
                $periodStart = Carbon::parse($dates[0])->toDateTimeString();
                $periodEnd = Carbon::parse($dates[1])->endOfDay()->toDateTimeString();
            }
            $query->whereBetween('created_at', [$periodStart, $periodEnd]);
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
            ->addColumn('category_note', function ($element) {
                if ($element->categoryNote) {
                    return $element->categoryNote->name;
                }
                return '';
            })
            ->addColumn('creator', function ($element) {
                if ($element->creator) {
                    return $element->creator->surnameWithInitials;
                }
                return '';
            })
            ->addColumn('user', function ($element) {
                if ($element->user) {
                    return $element->user->surnameWithInitials;
                }
                return '';
            })
            ->addColumn('status_note', function ($element) {
                if ($element->statusNote) {
                    return $element->statusNote->name;
                }
                return '';
            })
            ->addColumn('action', function ($element) {
                $routeName = $this->routeName;
                $result = '';
                if(auth()->user()->can('update_' . $this->permissionKey) and $this->checkOwner($element)) {
                    $result .= view($this->templatePath . 'edit_button', compact('element', 'routeName'));
                }
                if(auth()->user()->can('delete_any_' . $this->permissionKey)) {
                    $result .= view($this->templatePath . 'delete_button', compact('element', 'routeName'));
                }
                return $result;
            })
            ->addColumn('text', function ($element) {
                return mb_strimwidth($element->text, 0, 90, " ...");
            })
            ->filterColumn('category_note', function ($query, $keyword) {
                return $query->whereHas('categoryNote', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('status_note', function ($query, $keyword) {
                return $query->whereHas('statusNote', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('user', function ($query, $keyword) {
                return $query->whereHas('user', function ($query) use ($keyword) {
                    return $query->where('surname', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('creator', function ($query, $keyword) {
                return $query->whereHas('creator', function ($query) use ($keyword) {
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
    }

    /**
     * Создание записи в БД
     */
    public function store($request)
    {
        $requestAll = $request->all();
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

        $this->model->update($requestAll);

        $this->furtherPreparation($requestAll);

        return true;
    }


    private function furtherPreparation($requestAll)
    {
        $notDestroyFiles = [];

        if (isset($requestAll['new_scan_files']) and !empty($requestAll['new_scan_files'])) {
            foreach ($requestAll['new_scan_files'] as $newFile) {
                $fileSave = $newFile->store('notes', 'public');

                $notDestroyFiles[] = $this->model->files()->create([
                    'name' => $newFile->getClientOriginalName(),
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
                    $replaceFileSave = $replaceFile->store('notes', 'public');

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
        if ($this->model instanceof Note) {
            $note = $this->model;
            $noteFiles = $note->files()->orderedGet();
        } else {
            $note = new Note();
        }

        $categoryNotes = CategoryNote::select('id', 'name')->get();
        $statusNotes = StatusNote::select('id', 'name')->get();

        $userService = resolve('App\Services\Settings\UserService');
        $structuralUnits = $userService->getStructuredUsers();
        $IAmCreator = $this->checkOwner($note);

        return compact('note', 'categoryNotes', 'statusNotes', 'structuralUnits', 'noteFiles', 'IAmCreator');
    }

    /**
     * Данные для работы с элементом
     */
    public function checkOwner($element)
    {
       return $element->creator_id == auth()->id();
    }

}
