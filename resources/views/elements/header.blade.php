<nav class="bg-white py-3 px-4 md:py-4 md:px-4 mt-0 w-full">
    <div class="flex justify-between items-center relative">
        @hasSection('back')
            <a href="@yield('back')" class="absolute inline-block lg:hidden"><i class="fa fa-angle-left fa-lg"></i></a>
        @endif
        <div class="h-8 md:h-12 w-56 md:w-[250px] lg:m-0 mx-auto">
            <a href="/" class="h-full w-full inline-block flex items-center">
                <img class="lg:ml-4 object-cover w-full" src="{{ asset('images/logo/logo_ainavi.png') }}">
            </a>
        </div>
        <div class="items-center hidden lg:flex">
            <div class="px-8 hidden md:block w-full md:w-auto" id="mobile-menu">
                <ul class="flex-col md:flex-row flex md:space-x-8 mt-4 md:mt-0 md:text-sm md:font-medium">
                    <li>
                        @auth('user')
                            <button data-dropdown-toggle="dropdown1" class="text-gray-700 hover:bg-slate-200 border-b border-gray-100 md:hover:bg-transparent md:border-0 pl-3 pr-4 py-2 md:hover:text-gray-900 md:p-0 font-medium flex items-center justify-between w-full md:w-auto">車両を買う
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="dropdown1" class="absolute hidden bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow w-46">
                                <ul class="py-1" aria-labelledby="dropdownLargeButton">
                                    <li>
                                        <a href="{{ route('car.index') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">車両を探す</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('car_favorite.index') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">お気に入り車両</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('search_history.index') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">最近検索した条件</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('chat.index', ['tab' => TYPE_SELLER]) }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">チャット</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('order.buy') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">在庫確認・商談申込履歴</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('car.index') }}" class="text-gray-700 hover:bg-slate-200 border-b border-gray-100 md:hover:bg-transparent md:border-0 pl-3 pr-4 py-2 md:hover:text-gray-900 md:p-0 font-medium flex items-center justify-between w-full md:w-auto">車両を買う</a>
                        @endauth
                    </li>
                    <li>
                        @auth('user')
                            <button data-dropdown-toggle="dropdown2" class="text-gray-700 hover:bg-slate-200 border-b border-gray-100 md:hover:bg-transparent md:border-0 pl-3 pr-4 py-2 md:hover:text-gray-900 md:p-0 font-medium flex items-center justify-between w-full md:w-auto">車両を売る
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="dropdown2" class="absolute hidden bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow w-46">
                                <ul class="py-1" aria-labelledby="dropdownLargeButton">
                                    <li>
                                        <a href="{{ route('car_manager.create') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">車両を掲載する</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('car_manager.index') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">掲載車両一覧</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('order.sell') }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">在庫確認・商談申込受付状況</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('chat.index', ['tab' => TYPE_BUYER]) }}" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2 ">チャット</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('car_manager.create') }}" class="text-gray-700 hover:bg-slate-200 border-b border-gray-100 md:hover:bg-transparent md:border-0 pl-3 pr-4 py-2 md:hover:text-gray-900 md:p-0 font-medium flex items-center justify-between w-full md:w-auto">車両を売る</a>
                        @endauth
                    </li>
                </ul>
            </div>
            <div>
                @if(auth()->check())
                    <a href="{{ route('chat.index') }}">チャット</a>
                    <span class="px-4">|</span>
                    <a href="{{ route('account.index') }}">メニュー</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary font-normal border btn-sm px-8 mr-4">ログイン</a>
                    <a href="{{ route('register') }}" class="btn btn-primary font-normal btn-sm btn-icon px-8">無料会員登録<i class="fa fa-arrow-right fa-fw text-xs"></i>
                    </a>
                @endif
            </div>
            <span class="px-4">|</span>
            <a href="{{ route('contact.index') }}">お問い合わせ</a>
        </div>
    </div>
</nav>
