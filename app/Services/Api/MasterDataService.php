<?php

namespace App\Services\Api;

use App\Models\Category;

class MasterDataService
{
    public function __construct()
    {
    }

    public function getListCategories()
    {
        $categories = Category::all();
        $data   = [];
        foreach ($categories as $item) {
            $data[] = [
                'label' => $item->name,
                'value' => $item->id,
                'image' => asset($item->image_path)
            ];
        }
        return $data;
    }


}
