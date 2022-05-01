<?php
declare(strict_types=1);

namespace App\UseCases;

use App\Models\Sample;
use App\Models\SampleChild;
use App\Repositories\SampleChildRepository;
use App\Repositories\SampleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class SampleService
 * @package App\UseCase
 */
class SampleUseCase
{
    private $sampleRepository;
    private $sampleChildRepository;

    public function __construct(SampleRepository $sampleRepository, SampleChildRepository $sampleChildRepository)
    {
        $this->sampleChildRepository = $sampleChildRepository;
        $this->sampleRepository = $sampleRepository;
    }

    /**
     * 子サンプルと共に親サンプルのデータを取得する
     * @return Collection
     */
    public function getSamples(): Collection
    {
        $where = [];
        $with = ['sample_children'];
        $orderByList = [
            [
                'column' => 'id',
                'direction' => 'desc',
            ],
        ];

        return $this->sampleRepository->getAll($where, $with, $orderByList);
    }

    /**
     * 親サンプルと子サンプルを登録する
     * @param array $attributes
     * @return null|Sample
     */
    public function registerSample(array $attributes): ?Sample
    {
        DB::beginTransaction();

        try {
            $sample = $this->sampleRepository->createSample($attributes['parent']);

            $attributes['child']['sample_id'] = $sample->id;
            $this->sampleChildRepository->createSampleChild($attributes['child']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            return null;
        }

        DB::commit();

        return $sample;
    }
}
