<div class="bg-white shadow-lg p-4 rounded-md md:max-w-[345px] mx-auto" style="color: #062759">
    <span class="bg-slate-200 p-1 md:px-4 md:py-2">
        <span class="text-xs">お問い合わせ番号</span>
        <span class="text-sm">{{ $car->contact_code }}</span>
    </span>
    <h3 class="my-3 text-sm font-medium">
        <a href="{{ $link = route('car.show', $car->id) }}" title="{{ $car->name }}" class="line-clamp-1">{{ $car->name }}</a>
    </h3>
    <div class="flex flex-row gap-3 md:flex-col">
        <a href="{{ $link }}" title="{{ $car->name }}">
            <img class="w-[122px] h-[90px] md:w-full md:h-36 object-cover lazy"
                 alt="{{ $car->name }}"
                 data-src="{{ asset($car?->thumb?->url ?: config('img.no_image')) }}"/>
        </a>
        <div class="md:mt-2 flex-grow">
            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="border-t-2 border-gray-400 flex flex-col pt-1">
                    <span class="mb-2 text-xs">価格</span>
                    <span class="font-bold"><span class="text-xl">{!! price($car->price, true, 'md:text-sm') !!}</span><span class="ml-1 text-sm">万円</span></span>
                </div>
                <div class="border-t-2 border-orange-400 flex flex-col pt-1">
                    <span class="mb-2 text-xs">毎月支払い額</span>
                    <span class="font-bold"><span class="text-xl text-orange-400">{!! price($car->loan_payment, true, 'md:text-sm') !!}</span><span class="ml-1 text-sm">万円</span></span>
                </div>
            </div>
            <div class="grid grid-rows-4">
                <x-product-attribute type="grid" label="年式" :value="$car->model_year_y" :suffix="'('.$car->model_year_jp .')'"/>
                <x-product-attribute type="grid" label="走行距離" :value="$car->km_used ? km($car->km_used) : 0" suffix="千km"/>
                <x-product-attribute type="grid" label="最大積載量" :value="num($car->max_weight ?? 0, ',')" suffix="kg"/>
                <x-product-attribute type="grid" label="在庫場所" :value="$car->attribute_value['stock_location_id']"/>
            </div>
        </div>
        @if($addButton)
            <a href="{{ $link }}" title="{{ $car->name }}" class="btn btn-outline-primary border btn-md font-normal hidden md:inline-flex">詳細を見る</a>
        @endif
    </div>
</div>
