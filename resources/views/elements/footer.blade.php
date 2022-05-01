<footer class="border-t bg-slate-700 text-white pb-16 lg:pb-0 text-sm">
    <div class="container mx-auto">
        <div class="w-48 md:h-auto md:w-64 mt-3 mb-8 md:mt-8 md:mb-10">
            <a href="#" class="object-cover">
                <img src="{{ asset('images/logo/logo_ainavi.png') }}">
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-20">
            <div class="col-span-2">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 mb-8">
                    <div>
                        <h3 class="font-bold mb-5 border-b pb-3">形状で探す</h3>
                        <ul class="grid grid-cols-2">
                            @foreach (CAR_BODY_TYPE as $key => $item)
                                <li class="inline-block mb-2 md:mb-2.5">
                                    <a href="{{ route('car.index', ['body_type' => $key]) }}">> {{ $item }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold mb-5 border-b pb-3">メーカーで探す</h3>
                        <ul class="grid grid-cols-2">
                            @foreach (CAR_MANUFACTURE as $key => $item)
                                <li class="inline-block mb-2 md:mb-2.5">
                                    <a href="{{ route('car.index', ['manufacture' => $key]) }}">> {{ $item }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold mb-5 border-b pb-3">エリアで探す</h3>
                    @foreach (\App\Statics\ProvinceStatic::getListGroup() as $area => $items)
                        <div class="flex flex-col md:flex-row mb-2 md:mb-2.5">
                            <div class="md:w-36">> {{ $area }}</div>
                            <div class="flex flex-wrap">
                                @foreach($items as $item)
                                    <a href="{{ route('car.index', ['stock_location' => $item->id]) }}"><span class="whitespace-nowrap">{{ $item->name }} @if(!$loop->last) |&nbsp; @endif</span></a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="font-bold mb-3 lg:mb-8">ダウンロード</h3>
                <div class="mb-3 lg:mb-16">
                    <a href="{{LINK_APP_ANDROID}}"
                        class="inline-block mb-2" target="_blank"><img class="h-12 w-36 object-contain" src="{{ asset('images/icon/app_google.png') }}"/>
                    </a>
                    <a href="{{LINK_APP_IOS}}"
                        target="_blank">
                        <img class="h-12 w-36 object-contain" src="{{ asset('images/icon/app_apple.png') }}"/>
                    </a>
                </div>
{{--                <div class="font-bold mb-3 md:mb-8">フォローする</div>--}}
{{--                <div>--}}
{{--                    <a href="#"><i class="fab fa-facebook fa-3x"></i></a>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="text-center w-full py-6 lg:py-8">
            <div class="flex flex-wrap lg:inline-flex">
                <a href="{{ route('about') }}" title="会社概要" class="text-sm mr-5 mb-3 lg:mb-0 lg:mr-16">会社概要</a>
                <a href="{{ route('privacy_policy') }}" title="プライバシーポリシー" class="text-sm mr-5 mb-3 lg:mb-0 lg:mr-16">プライバシーポリシー</a>
                <a href="{{ route('terms_of_service') }}" title="利用規約" class="text-sm mr-5 mb-3 lg:mb-0 lg:mr-16">利用規約</a>
                <a href="{{ route('transaction_law') }}" title="特定商取引法に基づく表記" class="text-sm">特定商取引法に基づく表記</a>
            </div>
        </div>
    </div>
    <div class="py-2 text-xs text-center bg-white text-slate-700">Copyright © 2021 STEERLINK Rights Reserved.</div>
</footer>
