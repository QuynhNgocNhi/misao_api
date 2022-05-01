<?php

namespace App\Services;

use App\Models\Prefecture;
use Illuminate\Support\Facades\Cache;

class PrefectureService
{
    public function getList()
    {
        return Prefecture::get()->pluck('name', 'id');
    }

    public function getListGroup()
    {
        return Prefecture::get()->groupBy('area');
    }

    public function getListSp()
    {
        return Cache::rememberForever('prefecture', function () {
            return Prefecture::get(['name AS label', 'id AS value'])->toArray();
        });
    }
}
