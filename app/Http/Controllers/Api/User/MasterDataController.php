<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\MasterDataService;
use App\Traits\HasResponse;

class MasterDataController extends ApiController
{
    use HasResponse;
    //
    public function __construct(private MasterDataService $masterDataService)
    {
    }

    public function categories()
    {
        return $this->json($this->masterDataService->getListCategories());
    }

}
