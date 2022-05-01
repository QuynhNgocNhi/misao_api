<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'query',
        'md5'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'query' => 'array'
    ];

    protected $appends = [
        'query_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getQueryValueAttribute()
    {
        $value = [];
        foreach ($this->query as $key => $query) {
            if (!isset(FILTER_TITLE[$key])) continue;
            $queries = is_array($query) ? $query : explode(',', $query);
            foreach ($queries as $item) {
                $value[FILTER_TITLE[$key]][] = SEARCH_HISTORY[$key]['data'][$item] ?? '-';
            }
        }
        return $value;
    }

    public function getQueryValueTextAttribute()
    {
        $text  = '';
        $count = count($this->query_value);
        foreach ($this->query_value as $key => $value) {
            $last = --$count === 0;
            $text .= $key . ' : ' . (is_array($value) ? implode('、', $value) : $value) . ($last ? '' : '、');
        }

        return $text;
    }
}
