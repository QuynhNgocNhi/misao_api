<div class="product-item bg-white mb-6 rounded-md shadow-lg">
    <div class="p-2 md:p-5">
        @if(isset($badge) && $badge)
            {{ $badge }}
        @else
            <div class="flex justify-between">
                <span class="bg-slate-200 text-center leading-none md:leading-normal p-2 md:px-4 md:py-1 ">
                    <span class="text-[10px] md:text-xs block md:inline">お問い合わせ番号</span>
                    <span class="text-xs md:text-sm">{{ $car->contact_code }}</span>
                </span>
                @if($type !== 'order')
                    <a href="{{ route('login', ['redirect' => request()->fullUrlWithQuery(request()->query())]) }}"
                       class="flex md:hidden items-center flex-row-reverse @if(auth('user')->check()) js-store-favorite @endif" data-id="{{ $car->id }}">
                        <i class="fa fa-check-circle fa-fw fa-2x {{ $car->has_favorite ? 'text-blue-500' : 'text-gray-200' }}"></i>
                        <span class="text-slate-700">{{ $car->has_favorite ? '追加済み' : 'お気に入り登録する' }}</span>
                    </a>
                    <div class="hidden md:block">
                        @foreach($car->tag ?? [] as $tag)
                        <span class="badge-primary">#{{ CAR_TAG[$tag] }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        <h3 class="mb-1.5 mt-1 md:mb-0 md:mt-3 text-base md:text-xl text-slate-700 font-bold">
            <a href="{{ $link }}" title="{{ $car->name }}">{{ $car->name }}</a>
        </h3>
        <div class="block md:hidden">
            @foreach($car->tag ?? [] as $tag)
                <span class="badge-primary">#{{ CAR_TAG[$tag] }}</span>
            @endforeach
        </div>
        <div class="grid grid-cols-12 gap-4 py-3">
            <a href="{{ $link }}" title="{{ $car->name }}"
                class="col-span-6 md:col-span-5">
                <img class="w-full h-36 lg:h-44 object-cover lazy" alt="{{ $car->name }}"
                     data-src="{{ asset($car?->thumb?->url ?: config('img.no_image')) }}"/>
            </a>
            <div class="col-span-6 md:col-span-7">
                <div class="grid grid-cols-2 gap-4 mb-1 md:gap-8 md:mb-6">
                    <div class="border-t-2 border-gray-400 flex flex-col pt-1">
                        <span class="mb-2 text-[10px] lg:text-base">価格</span>
                        <span class="font-bold"><span class="text-sm md:text-3xl">{!! price($car->price, true) !!}</span><span class="ml-1 md:ml-3 text-sm">万円</span></span>
                    </div>
                    <div class="border-t-2 border-orange-400 flex flex-col pt-1">
                        <span class="mb-2 text-[10px] lg:text-base">毎月支払い額</span>
                        <span class="font-bold"><span class="text-sm md:text-3xl text-orange-400">{!! price($car->loan_payment, true) !!}</span><span class="ml-1 md:ml-3 text-sm">万円</span></span>
                    </div>
                </div>
                <div class="grid grid-rows-4 grid-rows-none md:grid-rows-none md:grid-cols-4">
                    <x-product-attribute :classMore="'md:bg-white'" label="年式" :value="$car->model_year_y" :suffix="'('.$car->model_year_jp .')'"/>
                    <x-product-attribute :classMore="'md:bg-white'" label="走行距離" :value="$car->km_used ? km($car->km_used) : 0" suffix="千km"/>
                    <x-product-attribute :classMore="'md:bg-white'" label="最大積載量" :value="num($car->max_weight ?? 0, ',')" suffix="kg"/>
                    <x-product-attribute :classMore="'md:bg-white'" label="在庫場所" :value="$car->attribute_value['stock_location_id']"/>

                </div>
            </div>
        </div>

        <div class="flex justify-between items-center">
            @if(isset($buttons) && $buttons)
                {{ $buttons }}
            @else
                <div class="flex justify-between items-center w-full">
                    @if($type !== 'order')
                        <a href="{{ route('login', ['redirect' => request()->fullUrlWithQuery(request()->query())]) }}"
                           class="md:flex hidden items-center @if(auth('user')->check()) js-store-favorite @endif" data-id="{{ $car->id }}">
                            <i class="fa fa-check-circle fa-fw fa-2x {{ $car->has_favorite ? 'text-blue-500' : 'text-gray-200' }}"></i>
                            <span class="text-slate-700">{{ $car->has_favorite ? '追加済み' : 'お気に入り登録する' }}</span>
                        </a>
                    @endif
                    <a href="{{ $link }}" title="{{ $car->name }}" class="btn btn-md btn-icon btn-primary px-14 text-base font-medium md:text-2xl w-full md:w-auto">詳細
                        <i class="fa fa-arrow-right"></i> </a>
                </div>
            @endif
        </div>
    </div>
</div>

