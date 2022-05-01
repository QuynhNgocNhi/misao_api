<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Storage;

abstract class CRUDAdminService extends BaseService
{

    public function search($data, $searchList, $tableList)
    {
        $params = array_merge($this->makeFilterParams($data, $searchList), $this->makeRelateParams($tableList));
        $query = $this->filter($params);

        return $query;
    }

    protected function makeFilterParams($data, $searchList)
    {
        $wheres = [];
        $whereIns = [];
        $likes = [];
        $whereHas = [];
        $multiLikes = [];
        $sort = '';
        if (!empty($data['sort']) && !empty($data['dir'])) {
            $sort = $data['sort'] . ':' . $data['dir'];
        } else {
            $sort = 'id:desc';
        }

        foreach ($searchList as $searchKey => $search) {
            if (isset($search['special'])) continue;

            if ((isset($searchList['created_at']) && $searchKey == 'created_at') ||
                (isset($searchList['publish_at']) && $search['type'] == 'dateFrom')) {

                $value = Arr::get($data, $searchKey . 'From');
            } else {
                $value = Arr::get($data, $searchKey, null);
            }
            if (is_null($value)) continue;

            $relateName = Arr::get($search, 'relate', null);
            $column = $searchKey;
            if (isset($search['type'])) {
                switch ($search['type']) {
                    case 'special':
                        break;
                    case 'dateFromTo':
                    case 'dateTo':
                    case 'dateFrom':

                        if ($column == 'publish_at') {
                            if (!empty($from = Arr::get($data, $column . 'From'))) {
                                $relateName ? $whereHas[$relateName][] = [$column, 'LIKE', '%' . $value . '%'] : $likes[$column] = $value;
                            }
                        } else {
                            if (!empty($from = Arr::get($data, $column . 'From'))) {
                                if (isset($search['date_format'])) {
                                    $from = date($search['date_format'], strtotime($from));
                                }
                                $relateName ? $whereHas[$relateName][] = [$column, '>=', $from] : $wheres[] = [$column, '>=', $from];
                            }
                        }

                        if (!empty($to = Arr::get($data, $column . 'To'))) {
                            if (isset($search['date_format'])) {
                                $to = date($search['date_format'], strtotime($to));
                            }
                            $relateName ? $whereHas[$relateName][] = [$column, '<=', $to] : $wheres[] = [$column, '<=', $to];
                        }
                        break;
                    case 'checkbox':
                        if (is_array($value)) {
                            $relateName ? $whereHas[$relateName][] = [$column, 'in', $value] : $whereIns[$column] = $value;
                        } else {
                            $relateName ? $whereHas[$relateName][] = [$column, $value] : $wheres[$column] = $value;
                        }
                        break;
                    case 'like':
                        $relateName ? $whereHas[$relateName][] = [$column, 'LIKE', '%' . $value . '%'] : $likes[$column] = $value;
                        break;
                    case 'multi_like':
                        if (!empty($search['attribute_name'])) {
                            if (is_array($search['attribute_name'])) {
                                $seperator = $search['multi_like_separator'] ?? '';
                                $columns = [];
                                $loop = count($search['attribute_name']);
                                foreach ($search['attribute_name'] as $attr) {
                                    $columns[] = $attr;
                                    if (0 !== --$loop) {
                                        $columns[] = '"' . $seperator . '"';
                                    }
                                }
                                $column = implode(', ', $columns);
                            } else {
                                $column = $search['attribute_name'];
                            }
                        }
                        $column = DB::raw("CONCAT({$column})");
                        $relateName ? $whereHas[$relateName][] = [$column, 'LIKE', '%' . $value . '%'] : $wheres[] = [$column, 'LIKE', '%' . $value . '%'];
                        break;
                    default:
                        if ($relateName) {
                            $whereHas[$relateName][] = [$column, '=', $value];

                        } else {
                            $wheres[$column] = $value;
                        }
                        break;
                }
            }
        }

        return [
            'wheres' => $wheres,
            'where_ins' => $whereIns,
            'likes' => $likes,
            'where_has' => $whereHas,
            'sort' => $sort
        ];
    }

    protected function makeRelateParams($tableList)
    {
        $relates = [];

        foreach ($tableList as $tableKey => $table) {
            if ($relate = Arr::get($table, 'relate', null)) {
                $relates[] = $relate;
            }
        }

        return ['relates' => $relates];
    }

    protected function hashPassword($params)
    {
        if (!empty($value = Arr::get($params, 'password'))) {
            if ($salt = Arr::get($params, 'password_salt')) {
                $params['password'] = Hash::make($value, ['salt' => $salt]);
            } else {
                $params['password'] = Hash::make($value);
            }
        } else {
            // remove null or empty string password
            unset($params['password']);
            unset($params['password_salt']);
        }

        return $params;
    }
}
