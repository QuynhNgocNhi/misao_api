<?php

namespace App\Helpers;

use App\Services\PrefectureService;
use Illuminate\Support\Facades\Cache;

class PrefectureHelper
{
    public static function getList()
    {
        return Cache::rememberForever('prefectures', function () {
            return app()->make(PrefectureService::class)->getList();
        });
    }

    public static function getListGroup()
    {
        return Cache::rememberForever('prefectures_group', function () {
            return app()->make(PrefectureService::class)->getListGroup();
        });
    }
}
