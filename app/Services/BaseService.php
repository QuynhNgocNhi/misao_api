<?php

namespace App\Services;

use App\Repositories\BaseRepository;

abstract class BaseService
{
    protected BaseRepository|null $repository = null;

    abstract function repositoryName(): string;

    public function __construct()
    {
        $this->setRepository();
    }

    private function setRepository()
    {
        $repositoryName = $this->repositoryName();
        $repository = app()->make($repositoryName);
        if (!($repository instanceof BaseRepository)) {
            throw new \Exception('Repository not found');
        }
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function get($params)
    {
        return $this->repository->get($params);
    }

    public function paginate($params, $limit)
    {
        return $this->repository->paginate($params, $limit);
    }

    public function filter($params)
    {
        return $this->repository->filter($params);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create($params)
    {
        $params = $this->hashPassword($params);
        $item = $this->repository->create($params);

        return $item;
    }

    public function update($id, $params)
    {
        $params = $this->hashPassword($params);

        $item = $this->repository->update($id, $params);

        return $item;
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }


    public function deleteAll(array $ids)
    {
        return $this->repository->deleteAll($ids);
    }
}
