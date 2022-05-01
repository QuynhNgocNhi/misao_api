<?php

namespace App\Services\Api;

use App\Repositories\BuyRequestRepository;
use App\Repositories\ProductMediaRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class  BuyRequestService
{
    public function __construct(
        private BuyRequestRepository      $buyRequestRepository,
        private ProductMediaRepository $productMediaRepository
    ) {
    }

    public function findByContactCode(string $contactCode)
    {
        return $this->buyRequestRepository->findBy($contactCode, 'contact_code');
    }

    public function getListSearch(array $params = [], $userIdFavorite = null, $limit = 10)
    {
        $onlyFavorite  = Arr::get($params, 'only_favorite');
        $keyword = Arr::get($params, 'keyword');
        $whereEquals   = [
            'user_id' => Arr::get($params, 'user_id'),
            'is_active'  => Arr::get($params, 'is_active'),
            'category_id'  => Arr::get($params, 'category_id'),

        ];
        $whereBetweens = [
            'price'               => $this->transformMultiRequest(Arr::get($params, 'price'), 10000),
        ];


        $whereIns   = [
            // 'city'   => $this->getValueWhereIn($params, 'stock_location'),
        ];
        $whereLikes = [
            'name' => Arr::get($params, 'keyword'),
        ];

        $params     = [
            'where_equals'   => $whereEquals,
            'where_betweens' => $whereBetweens,
            'where_ins'      => $whereIns,
            'where_likes'    => $whereLikes,
            'sort'           => Arr::get($params, 'sort', 'updated_at:desc'),
        ];
        if (!$userIdFavorite) {
            return $this->buyRequestRepository
                ->buyRequestFilter($params)
                ->withCount('favorite')
                ->paginate(10);
        }
        return $this->buyRequestRepository->buyRequestFilter($params)
            ->when($keyword, function ($query) use ($keyword) {
                $query->orWhere('description', 'LIKE', '%' . $keyword . '%');
            })
            ->when(
                $onlyFavorite,
                function ($query) use ($userIdFavorite) {
                    $query->join('buy_request_favorites AS cf', function ($join) use ($userIdFavorite) {
                        $join->on('cf.buy_request_id', '=', 'buy_requests.id')
                            ->where('cf.user_id', $userIdFavorite)
                            ->whereNull('cf.deleted_at');
                    });
                },
                function ($query) use ($userIdFavorite) {
                    $query->leftJoin('buy_request_favorites AS cf', function ($join) use ($userIdFavorite) {
                        $join->on('cf.buy_request_id', '=', 'buy_requests.id')
                            ->where('cf.user_id', $userIdFavorite);
                    });
                }
            )
            ->select('buy_requests.*', DB::raw("IF(cf.id, IF(cf.deleted_at, 0, 1), 0) as has_favorite"))
            ->withCount('favorite')
            ->paginate($limit);
    }

    private function transformMultiRequest($values, int $multi)
    {
        if (empty($values)) return [];
        $values = is_string($values) ? explode(',', $values) : $values;
        return [$values[0] * $multi, $values[1] * $multi];
    }

    public function getListHasOrder(array $params, $limit = 10)
    {
        $whereEquals = [
            'user_id' => Arr::get($params, 'user_id'),
            'is_active'  => Arr::get($params, 'is_active'),
        ];
        $params      = [
            'where_equals' => $whereEquals,
        ];
        return $this->buyRequestRepository->filter($params)
            ->has('orders')
            ->withCount('orders')
            ->paginate($limit);
    }


    public function getListHome(int $limit = 8)
    {
        $params = [
            'sort' => 'updated_at:desc'
        ];
        return $this->buyRequestRepository->getList($params, $limit);
    }

    public function show(int $id, int $userId = null)
    {
        return $this->buyRequestRepository->getModel()
            ->with('images')
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->find($id);
    }

    public function showWithFavorite(int $id, int $userIdFavorite = null)
    {
        return $this->buyRequestRepository->getModel()
            ->withCount('favorite')
            ->with([
                'images',
                'favorite' => function ($query) use ($userIdFavorite) {
                    $query->where('user_id', $userIdFavorite);
                }
            ])
            ->find($id);
    }


    public function delete(int $id)
    {
        $product = $this->show($id, auth()->id());
        if (!$product) return false;
        try {
            $product->images()->delete();
            $product->delete();
        } catch (\Exception $e) {
            logger()->error($e);
            return false;
        }
        return true;
    }

    public function release($id)
    {
        $car = $this->show($id, auth()->id());
        if (!$car) return false;
        if ($car->status === 1) return false;

        $this->buyRequestRepository->update($id, [
            'status' => 1
        ]);
        return true;
    }

    public function store(array $params)
    {
        $data        = $this->makeData($params);
        $mediaActive = Arr::get($params, 'media_active');
        $data        = array_merge($data, [
            'status'        => 0,
            'user_id' => $userId = Arr::get($params, 'user_id')
        ]);

        $car = $this->buyRequestRepository->create($data);
        $car->update([
            'contact_code' => $this->createContactCode($userId, $car->id)
        ]);
        if (!empty($mediaActive)) {
            $this->productMediaRepository->updateProductToMedia($mediaActive, $car->id);
        }
        return $car;
    }

    public function update(int $id, array $params)
    {
        $data        = $params;
        $mediaInActive = Arr::get($params, 'media_in_active');
        $product = $this->buyRequestRepository->update($id, $data);
        if (!empty($mediaInActive)) {
            $product->images()->whereIn('id', $mediaInActive)->delete();
        }

        return $product;
    }

    private function makeData(array $params)
    {
        $params = Arr::except($params, ['user_id', 'admin_id', 'approve', 'status']);
        return array_merge($params, [
            'car_size_id'   => $this->getCarSize(Arr::get($params, 'car_weight_id')),
            'mile_used'     => km_to_mile(Arr::get($params, 'km_used')),
            'license_type'  => $this->getLicenseType(Arr::get($params, 'total_weight'), Arr::get($params, 'max_weight'))
        ]);
    }

    private function getLicenseType($totalWeight, $maxWeight)
    {
        $result = 0;
        if ($totalWeight <= 3500 && $maxWeight <= 2000) {
            $result = 1;
        } else if ($result === 0 && $totalWeight <= 7500 && $maxWeight <= 4500) {
            $result = 2;
        }
        return $result;
    }

    private function getCarSize($carWeight)
    {
        if ($carWeight >= 6 /*10t*/) return 4; /*小型*/
        elseif ($carWeight >= 4 /*4t*/ && $carWeight <= 5 /*中増t*/) return 3; /*中型*/
        elseif ($carWeight >= 2 /*2t*/ && $carWeight <= 3 /*3t*/) return 2; /*増トン*/
        else  return 1; /*大型*/
    }



    private function createContactCode($userId, $carId)
    {
        return str_pad($userId, 2, 0, STR_PAD_LEFT) . '-' . str_pad($carId, 3, 0, STR_PAD_LEFT); // format xx-xxx
    }
}
