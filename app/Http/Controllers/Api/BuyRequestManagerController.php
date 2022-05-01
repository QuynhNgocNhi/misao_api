<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\BuyRequestMediaService;
use App\Services\Api\BuyRequestService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class BuyRequestManagerController extends ApiController
{
    use HasResponse;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private BuyRequestService $buyRequestService,
        private BuyRequestMediaService $buyRequestMediaService
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['is_active'] = 1;
        $params['user_id'] = auth('api')->id();
        $data = $this->buyRequestService->getListSearch($params, null, $request->get('limit', 10));

        return $this->json($data);
    }

    public function upload($productID, $files)
    {
        $medias = $this->buyRequestMediaService->upload($productID, $files);
        return $medias;
    }

    public function store(Request $request)
    {
        if (!$request->confirm) {
            return $this->json([]);
        }

        $params = $request->all();
        $params['user_id'] = auth('api')->id();
        $result = $this->buyRequestService->store($params);
        if ($result) {
            $files = $request->file('files');
            $this->upload($result->id, $files);
        }

        return $this->json(
            $result ? $result : [],
            $result ? 'success' : 'error',
            $result ? 200 : 400
        );
    }

    public function show($id)
    {
        $data = $this->buyRequestService->show($id, auth('api')->id());
        return $this->json($data);
    }


    public function update(Request $request, $id)
    {
        if (!$request->confirm) {
            return $this->json([]);
        }

        $files = $request->file('files');
        if ($files) {
            $this->upload($id, $files);
        }

        $result = $this->buyRequestService->update($id, $request->all());

        return $this->json(
            $result ?: [],
            $result ? 'success' : 'error',
            $result ? 200 : 400
        );
    }

    public function delete($id)
    {
        $result = $this->buyRequestService->delete($id);
        return $this->responseSuccess();
    }
}
