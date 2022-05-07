<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\ProductMediaRequest;
use App\Services\Api\ProductMediaService;
use App\Services\Api\ProductService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class ProductManagerController extends ApiController
{
    use HasResponse;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private ProductService $productService,
        private ProductMediaService $productMediaService
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['user_id'] = auth('api')->id();
        $data = $this->productService->getListSearch($params, null, $request->get('limit', 10));

        return $this->json($data);
    }

    public function upload($productID, $files)
    {
        $medias = $this->productMediaService->upload($productID, $files);
        return $medias;
    }

    public function store(Request $request)
    {
        if (!$request->confirm) {
            return $this->json([]);
        }

        $params = $request->all();
        $params['user_id'] = auth('api')->id();
        $product = $this->productService->store($params);
        if ($product) {
            $files = $request->file('files');
            $this->upload($product->id, $files);
        }

        return $this->json(
            $product ? $product : [],
            $product ? 'success' : 'error',
            $product ? 200 : 400
        );
    }

    public function show($id)
    {
        $data = $this->productService->show($id, auth('api')->id());
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

        $result = $this->productService->update($id, $request->all());

        return $this->json(
            $result ?: [],
            $result ? 'success' : 'error',
            $result ? 200 : 400
        );
    }

    public function delete($id)
    {

        $result = $this->productService->delete($id);
        return $this->json(
            $result ?: [],
            $result ? 'success' : 'error',
            $result ? 200 : 400
        );
    }
}
