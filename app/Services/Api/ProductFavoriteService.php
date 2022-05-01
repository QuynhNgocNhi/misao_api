<?php

namespace App\Services\Api;

use App\Repositories\ProductFavoriteRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class ProductFavoriteService
{
    public function __construct(private ProductFavoriteRepository $productFavoriteRepository)
    {
    }

    public function getList(array $params)
    {
    }

    public function find(array $params)
    {
        $whereEquals = [
            'product_id'  => Arr::get($params, 'product_id'),
            'user_id' => Arr::get($params, 'user_id'),
        ];
        $params       = [
            'where_equals' => $whereEquals
        ];
        return $this->productFavoriteRepository->filter($params)->withTrashed()->first();
    }

    public function store(array $params)
    {
        $productId     = Arr::get($params, 'product_id');
        $userId    = Arr::get($params, 'user_id');
        $keyCache  = 'favorite' . $productId . $userId;
        if (Cache::has($keyCache)) {
            return 'Vui lòng không gửi yêu cầu liên tục';
        }
        Cache::put($keyCache, 'clicked', 2);
        $input = [
            'product_id'  => $productId,
            'user_id' => $userId,
        ];
        $productFavorite       = $this->find($input);
        if ($productFavorite) {
            if (is_null($productFavorite->deleted_at)) {
                return $this->delete($productFavorite->id) ? 'Đã xóa khỏi mục yêu thích.' : false;
            } else {
                return $productFavorite->restore() ? 'Đã thêm khỏi mục yêu thích.' : false;
            }
        }
        return $this->productFavoriteRepository->create($input) ? 'Đã thêm khỏi mục yêu thích.' : false;
    }

    public function delete(int $id)
    {
        return $this->productFavoriteRepository->delete($id);
    }
}
