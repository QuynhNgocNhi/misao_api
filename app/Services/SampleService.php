<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Sample;
use App\Models\SampleChild;
use App\Repositories\SampleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class SampleService
 * @package App\Services
 */
class SampleService
{
    private $repository;
    public function __construct(SampleRepository $repository)
    {
       $this->repository = $repository;
    }

    public function get(): Collection
    {
        return $this->repository->get();
    }


    public function create(array $params): ?Sample
    {
        DB::beginTransaction();;

        try {
            $sample = $this->repository->create($params);
            $sample2 = $this->repository->create($params);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            return null;
        }

        DB::commit();

        return $sample;
    }
}
