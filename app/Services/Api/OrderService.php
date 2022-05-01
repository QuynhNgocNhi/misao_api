<?php

namespace App\Services\Api;

use App\Events\ApplyCar;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\Api\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        // private ChatService     $chatService,
        private UserService     $userService,
        private ProductRepository   $productRepository
    ) {
    }

    public function get(array $params = [], $limit = PER_PAGE)
    {
        $whereEquals = [
            'status' => Arr::get($params, 'status', null),
        ];
        $params      = [
            'where_equals' => $whereEquals,
            'sort'         => Arr::get($params, 'sort', null),
            // 'relates'      => ['user', 'product.thumb'],
            'user_id'      => Arr::get($params, 'user_id', null),
        ];

        return $limit > 0 ? $this->orderRepository->paginate($params, $limit) : $this->orderRepository->get($params);
    }

    public function show(int $id)
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            return null;
        }
        $order->load([
            'product',
            'product.images',
            'seller',
            'buyer',
            'buyRequest',
        ]);
        return $order;
    }

    public function create(array $params, User $user)
    {
        $order = $this->orderRepository->create($params);
        // create chat room
        // $chatRoom = $order->chat_room()->create([
        //     'buyer_id'  => $order->user_id,
        //     'seller_id' => $order->car->user_id,
        //     'car_id'    => $order->car->id,
        // ]);
        // $paramMsg = [
        //     'chat_room_id' => $chatRoom->id,
        //     'content'      => Arr::get($params, 'content'),
        // ];
        // $this->chatService->sendMessage($paramMsg, $user);

        // $paramMsg = [
        //     'chat_room_id' => $chatRoom->id,
        //     'content'      => 'お問い合わせありがとうございます。 内容を確認の上、販売会社様よりメッセージをお送りさせて頂きます。 【注意事項】 ・定休日の場合、ご連絡にお時間をちょうだいする可能性がございます。 ・このメッセージは自動返信されています。'
        // ];
        // $this->chatService->sendMessage($paramMsg, $this->userService->find(Arr::get($params, 'user_sell_id')));
        return $order;
    }

    public function update($id, array $params)
    {
        $params = Arr::only($params, ['status']);

        return $this->orderRepository->update($id, $params);
    }

    public function delete(int $id)
    {
        $order = $this->show($id);
        if (!$order) return false;
        $authId = auth()->id();
        // if (!($authId == $order->user_id || $authId == $order->user_sell_id)) {
        //     return false;
        // }
        // $order->chat_room()->delete();

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return false;
        }

        return $authId == $order->user_sell_id ? TYPE_SELLER : TYPE_BUYER;
    }

    public function getList(array $params, $limit = PER_PAGE)
    {
        $whereEquals = [
            'status' => Arr::get($params, 'status'),
        ];
        if (Arr::get($params, 'user_type') == TYPE_BUYER) {
            $whereEquals['user_id'] = Arr::get($params, 'user_id');
        } else {
            $whereEquals['user_sell_id'] = Arr::get($params, 'user_id');
        }
        $params = [
            'where_equals' => $whereEquals,
        ];
        return $this->orderRepository->filter($params)
            ->with([
                'seller',
                'buyer',
                'product.images',
                'buyRequest',
            ])->paginate($limit);
    }

    public function checkIsExisted(int $carId)
    {
        $order = $this->orderRepository->getModel()
            ->where('car_id', $carId)
            ->where('user_id', auth()->id())
            ->first();
        return $order ? $order : false;
    }

    public function getListHumanBuy(array $params, $limit = PER_PAGE)
    {
        return $this->orderRepository->filterByCar($params, $limit);
    }
}
