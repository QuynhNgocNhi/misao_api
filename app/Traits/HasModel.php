<?php

namespace App\Traits;

trait HasModel
{
    /**
     * Scope a query to only include active record.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', ACTIVE);
    }
}
