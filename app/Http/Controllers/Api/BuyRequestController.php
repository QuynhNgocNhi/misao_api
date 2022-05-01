<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\BuyRequestFavoriteService;
use App\Services\Api\BuyRequestService;
use App\Services\Api\SearchHistoryService;
use Illuminate\Http\Request;

class BuyRequestController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private BuyRequestService         $buyRequestService,
        private BuyRequestFavoriteService $buyRequestFavoriteService,
        private SearchHistoryService $searchHistoryService,
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['is_active'] = 1;
        $params['is_draft'] = 1;
        $data = $this->buyRequestService->getListSearch($params, auth('api')->id(), $request->get('limit', 10));
        return $this->json($data);
    }


    public function show($id)
    {
        $data = $this->buyRequestService->showWithFavorite($id, auth('api')->id());
        return $this->json($data);
    }


    public function favorite($id)
    {
        $params = [
            'buy_request_id'  => $id,
            'user_id' => auth('api')->id(),
        ];
        $result = $this->buyRequestFavoriteService->store($params);

        return $this->json([], $result ? 'success' : 'error', $result ? 200 : 400);
    }

    public function favoriteList(Request $request)
    {
        $params = $request->query();
        $params = array_merge($params, [
            'status' => 1,
            'only_favorite' => true
        ]);
        $data = $this->buyRequestService->getListSearch($params, auth('api')->id());

        return $this->json($data);
    }
}
