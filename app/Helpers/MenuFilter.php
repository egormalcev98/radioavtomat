<?php

namespace App\Helpers;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
		if (isset($item['permission']) and is_array($item['permission']) and !auth()->user()->can($item['permission'])) {
            return false;
        }
		
        return $item;
    }
}