<?php

namespace App\Repositories;

use App\Traits\HasQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {
    use HasQuery;

    protected Model $model;

    abstract function modelName(): string;

    public function __construct()
    {
        $this->setModel();
    }

    private function setModel()
    {
        $modelName = $this->modelName();
        $model = new $modelName;
        if (!($model instanceof Model)) {
            throw new \Exception('Model not found');
        }
        $this->model = $model;
    }

    function getModel(): Model
    {
        return $this->model;
    }

    public function find(int $id): ?Model
    {
        return $this->findBy($id);
    }

    public function with($with, $value, $column = 'id'){
        return $this->getModel()->with($with)->where($column, $value)->first();
    }

    public function findBy($value, $column = 'id'): ?Model
    {
        return $this->getModel()->where($column, $value)->first();
    }

    public function filter(array $params): Builder
    {
        $query = $this->getModel()->query();

        // query common field
        $whereEquals = $this->buildWhereEqual(array_merge($params['where_equals'] ?? [], $params['wheres'] ?? []));
        $whereLikes = $this->buildWhereLike(array_merge($params['where_likes'] ?? [], $params['likes'] ?? []));
        $whereIns = $this->buildWhereIn($params['where_ins'] ?? []);
        $whereHas = $this->cleanValueNull($params['where_has'] ?? []);
        $orWheres = $this->cleanValueNull($params['or_wheres'] ?? []);
        $sort = $this->buildSort($params['sort'] ?? '');
        $relates = $params['relates'] ?? null;

        // multi sort
        $sorts = [];
        $sortsParam = ($params['sorts'] ?? []);
        if (is_array($sortsParam)) {
            foreach ($sortsParam as $sortParam){
                $sorts[] = $this->buildSort($sortParam);
            }
        }

        $query
            ->when($whereEquals, function ($query) use ($whereEquals) {
                $query->where($whereEquals);
            })
            ->when($whereIns, function ($query) use ($whereIns) {
                $query->where($whereIns);
            })
            ->when($whereLikes, function ($query) use ($whereLikes) {
                $query->where($whereLikes);
            })
            ->when(!empty($whereHas), function ($query) use ($whereHas) {
                foreach ($whereHas as $relateName => $conditions) {
                    if (!empty($conditions)) {
                        $query->whereHas($relateName, function ($subQuery) use ($conditions) {
                            foreach ($conditions as $condition) {
                                if (($condition[0] ?? false) && ($condition[2] ?? false) && strtoupper($condition[1] ?? false) === 'IN') {
                                    $subQuery->whereIn($condition[0], $condition[2]);
                                } else {
                                    $subQuery->where([$condition]);
                                }
                            }
                        });
                    }
                }
            })
            ->when(!empty($orWheres), function ($query) use ($orWheres) {
                $query->where(function ($query) use ($orWheres) {
                    foreach ($orWheres as $orWhere) {
                        $query->orWhere($orWhere);
                    }
                });
            })
            ->when(!empty($sorts), function ($query) use ($sorts) {
                foreach ($sorts as $sort) {
                    if (!empty($sort)) {
                        if (str_contains($sort['column'], 'raw|')) {
                            $sort['column'] = str_replace('raw|', '', $sort['column']);
                            $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                        } else {
                            $query->orderBy($sort['column'], $sort['direction']);
                        }

                    }
                }
            })
            ->when(!empty($sort), function ($query) use ($sort) {
                if (str_contains($sort['column'], 'raw|')) {
                    $sort['column'] = str_replace('raw|', '', $sort['column']);
                    $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                } else {
                    $query->orderBy($sort['column'], $sort['direction']);
                }
            })
            ->when(!empty($relates), function ($query) use ($relates) {
                $query->with($relates);
            });
        return $query;
    }

    public function get(array $params = []): Collection
    {
        return $this->filter($params)->get();
    }

    public function paginate(array $params = [], $limit = PER_PAGE)
    {
        return $this->filter($params)->paginate($limit);
    }

    public function create(array $params)
    {
        return $this->getModel()->create($params);
    }

    public function update($id, array $params)
    {
        $result = $this->getModel()->find($id);
        $result->fill($params);
        $saved = $result->save();

        return $saved ? $result : null;
    }

    public function updateWithTimestamp($id, array $params, $timestamps  = true)
    {
        $result = $this->getModel()->find($id);
        $result->fill($params);
        $result->timestamps = $timestamps;
        $saved = $result->save();

        return $saved ? $result : null;
    }

    public function delete(int $id)
    {
        return $this->getModel()->where('id', $id)->delete();
    }

    public function forceDelete(int $id)
    {
        return $this->getModel()->where('id', $id)->forceDelete();
    }

    public function deleteAll(array $ids)
    {
        return $this->getModel()->whereIn('id', $ids)->delete();
    }

    public function insert(array $params)
    {
        return $this->getModel()->insert($params);
    }

    public function deleteBy($value, $column = 'id')
    {
        return $this->getModel()->where($column, $value)->delete();
    }
}
