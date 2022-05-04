<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\Order\GetListRequest;
use App\Http\Requests\User\Order\RequestFormRequest;
use App\Services\Api\BuyRequestService;
use App\Services\Api\OrderService;
use App\Services\Api\ProductService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    use HasResponse;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private ProductService   $productService,
        private BuyRequestService   $buyRequestService,
        private OrderService $orderService
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = auth('api')->id();
        $params['status'] = ($params['status'] ?? null) ?: null; // unset status 0 => search all status
        $data = $this->orderService->getList($params, $request->get('limit', PER_PAGE));

        return $this->json($data);
    }

    public function getListHumanBuy(Request $request)
    {
        $params   = $request->all();
        $params   = array_merge($params, [
            'status'    => 1
        ]);
        $data     = $this->orderService->getListHumanBuy($params);
        return $this->json($data);
    }

    public function store(Request $request)
    {
        if (!$request->confirm) {
            return $this->json(auth('api')->user());
        }
        $params = [
            'user_sell_id' => $request->user_seller_id,
            'product_id'       => $request?->product_id,
            'buy_request_id'       => $request?->buy_request_id,
            'user_id' => auth('api')->id()
        ];
        $data = $this->orderService->create($params, auth('api')->user());
        $data->load(['chat_room']);
        return $this->json($data);
    }

    public function show($id)
    {
        $data = $this->orderService->show($id);
        if (!$data) {
            return $this->json([], '404', 404);
        }

        return $this->json($data);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $result = $this->orderService->delete($request->get('id'));
        return $this->responseSuccess();
    }
}
