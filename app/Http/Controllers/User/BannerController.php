<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Api\BannerService;
use App\Helpers\MetaSeoRender;

class BannerController extends Controller
{
    public function __construct(
        public BannerService $bannerService)
    {
    }

    public function show($id)
    {
        $banner = $this->bannerService->show($id);
        if(!$banner) abort(404);

        $metaSeo           = [
            'meta_title' => $banner->title
        ];
        $viewData = [
            'meta_seo' => MetaSeoRender::setMetaSeo($metaSeo),
            'banner' => $banner
        ];
        return view('pages.banner.detail')->with($viewData);
    }
}
