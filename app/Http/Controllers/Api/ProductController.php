<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\ProductFavoriteService;
use App\Services\Api\ProductService;
use App\Services\Api\SearchHistoryService;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private ProductService         $productService,
        private ProductFavoriteService $productFavoriteService,
        private SearchHistoryService $searchHistoryService,
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['is_active'] = 1;
        $data = $this->productService->getListSearch($params, auth('api')->id(), $request->get('limit', 10));
        if (auth('api')->check()) {
            $this->searchHistoryService->store($request->query(), auth('api')->user());
        }

        return $this->json($data);
    }

    public function hotProductList(Request $request)
    {
        $params = $request->all();
        $params['is_active'] = 1;
        $data = $this->productService->getListSearch($params, auth('api')->id(), 12);
        return $this->json($data);
    }

    public function show(int $id)
    {
        $data = $this->productService->showWithFavorite($id, auth('api')->id());
        return $this->json($data);
    }

    public function searchRecent()
    {
        $params['user_id'] = auth('api')->id();
        $searchHistories = $this->searchHistoryService->getList($params);
        return $this->json($searchHistories);
    }

    public function favorite($id)
    {
        $params = [
            'product_id'  => $id,
            'user_id' => auth('api')->id(),
        ];
        $result = $this->productFavoriteService->store($params);

        return $this->json([], $result ? 'success' : 'error', $result ? 200 : 400);
    }

    public function favoriteList(Request $request)
    {
        $params = $request->query();
        $params = array_merge($params, [
            'status' => 1,
            'only_favorite' => true
        ]);

        $data = $this->productService->getListSearch($params, auth('api')->id());

        return $this->json($data);
    }
}
