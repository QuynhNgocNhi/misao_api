<?php

namespace App\Traits;

use Crawler;

trait HasCountView
{
    public function countView(string $field = 'total_viewed')
    {
        if (Crawler::isCrawler()) {
            return;
        }
        $key = $this->table . '_viewed_' . $this->id;
        if (\Session::has($key)) {
            return;
        }
        \DB::table($this->table)
            ->where('id', $this->id)
            ->increment($field);
        \Session::put($key, 1);
    }
}
