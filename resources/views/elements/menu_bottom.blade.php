<div class="fixed z-10 bottom-0 w-full bg-white h-16 block lg:hidden footer_mobile">
    <div class="grid grid-cols-4 gap-4 items-center h-full justify-center">
        <a href="/" class="inline-block text-center flex flex-col items-center"><img class="text-xl h-5 w-5" src="{{ asset('images/icon/icon_home.png') }}"/><div class="text-xs mt-1">ホーム</div></a>
        <a href="{{ route('car.index') }}" class="inline-block text-center flex flex-col items-center"><img class="text-xl h-5 w-5" src="{{ asset('images/icon/icon_search.png') }}"/><div class="text-xs mt-1">探す</div></a>
        <a href="{{ route('chat.index') }}" class="inline-block text-center flex flex-col items-center"><img class="text-xl h-5 w-5" src="{{ asset('images/icon/icon_message.png') }}"/><div class="text-xs mt-1">チャット</div></a>
        <a href="{{ route('account.index') }}" class="inline-block text-center flex flex-col items-center"><img class="text-xl h-5 w-5" src="{{ asset('images/icon/icon_menu.png') }}"/><div class="text-xs mt-1">メニュー</div></a>
    </div>
</div>
