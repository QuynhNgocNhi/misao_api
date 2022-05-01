<?php

namespace App\Repositories;

use App\Models\Product;
use App\Traits\HasQuery;

class ProductRepository extends BaseRepository
{
    use HasQuery;

    function modelName(): string
    {
        return Product::class;
    }

    public function productFilter(array $params)
    {
        $whereEquals  = $this->buildWhereEqual($params['where_equals'] ?? []);
        $whereIns     = $this->buildWhereIn($params['where_ins'] ?? []);
        $whereLikes   = $this->buildWhereLike($params['where_likes'] ?? []);
        $whereBetween = $this->buildWhereBetween($params['where_betweens'] ?? []);
        // $orWheres = $this->cleanValueNull($params['or_wheres'] ?? []);
        $sort         = $this->buildSort($params['sort'] ?? []);
        return $this->getModel()
            ->with('images')
            ->when($whereEquals, function ($query) use ($whereEquals) {
                $query->where($whereEquals);
            })
            ->when($whereBetween, function ($query) use ($whereBetween) {
                foreach ($whereBetween as $key => $value) {
                    $query->whereBetween($key, $value);
                }
            })
            ->when($whereIns, function ($query) use ($whereIns) {
                foreach ($whereIns as $field => $whereIn) {
                    $query->whereIn($field, $whereIn);
                }
            })
            ->when($whereLikes, function ($query) use ($whereLikes) {
                $query->where($whereLikes);
            })
            ->when($sort, function ($query) use ($sort) {
                $query->orderBy($sort['column'], $sort['direction']);
            });
    }

    public function getListPaginate(array $params)
    {
        return $this->productFilter($params)->paginate(10);
    }

    public function getList(array $params, int $limit = 8)
    {
        return $this->getModel()->active()
            ->limit($limit)->orderBy('updated_at', 'desc')->get();
    }

    public function findById($id)
    {
        return $this->getModel()->active()
            ->with('images')->find($id);
    }

    public function update($id, array $params)
    {
        $result = $this->getModel()->find($id);
        $result->fill($params);
        $result->save();
        return $result;
    }
}
