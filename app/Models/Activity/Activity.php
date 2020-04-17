<?php

namespace App\Models\Activity;

use App\Models\BaseModel;
use Spatie\Activitylog\Traits\LogsActivity;

class Activity extends BaseModel
{
    use LogsActivity;

    protected static $logName = __CLASS__; // надо переопределить в потомках !!! под каким именем будет записываться в журнал эта модель
    protected static $logAttributes = ['*']; // поля по которым отслеживаем изменения. долго перечислять нужные поэтому тут выбираем все а потом отбросим ненужные
    protected static $logOnlyDirty = true; // записываем данные только тех полей, который были изменены
    // protected static $ignoreChangedAttributes = ['updated_at']; //не записываем в журнал если изменилось только поле updated_at (не работает. поэтому используем следущие 2 строчки)
    protected static $logAttributesToIgnore = ['updated_at']; // игнорируем изменения поля updated_at
    protected static $submitEmptyLogs = false; // не пишем в журнал если никакие поля не менялись

    /*
     protected static $forcedOldAttributes = []; // поля, которые вытаскиваем в массив old даже если они не были изменены

    чтобы $forcedOldAttributes работало надо в \vendor\spatie\laravel-activitylog\src\Traits\DetectsChanges.php
    допилить public function attributeValuesToBeLogged(string $processingEvent): array.

    Вместо
     $properties['old'] = collect($properties['old'])
                ->only(array_keys($properties['attributes']))
                ->all();

    Добавить
    if(isset(static::$forcedOldAttributes) and is_array(static::$forcedOldAttributes)){
                $only = array_merge(array_keys($properties['attributes']), static::$forcedOldAttributes);
            } else {
                $only = array_keys($properties['attributes']);
            }
            $properties['old'] = collect($properties['old'])
                ->only($only)
                ->all();
    */

}

/*
    "При использовании массового удаления Eloquent для удаляемых моделей не будут возникать события deleting и deleted.
    Это происходит потому, что на самом деле модели вообще не извлекаются при выполнении оператора удаления."

    это значит что при массовом удалении LogsActivity не будет работать.

    тоесть Qwerty::find(12)->delete() так будет работать

    Qwerty::where('id', 12)->delete() а так нет
*/
