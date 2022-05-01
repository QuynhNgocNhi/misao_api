<div>
    <div class="mb-8">
        <h3 class="px-6 lg:px-0 text-slate-700 font-bold mb-4">車両を買う</h3>
        <div class="flex flex-col">
            <a href="{{ route('car_favorite.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>お気に入り車両</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('search_history.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>最近検索した条件</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('chat.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>チャット</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('order.buy') }}" class="flex justify-between bg-white px-6 py-3 border"><span>在庫確認・商談申込履歴</span><i class="fa fa-angle-right fa-fw"></i></a>
        </div>
    </div>
    <div class="mb-8">
        <h3 class="px-6 lg:px-0 text-slate-700 font-bold mb-4">車両を売る</h3>
        <div class="flex flex-col">
            <a href="{{ route('car_manager.create') }}" class="flex justify-between bg-white px-6 py-3 border"><span>車両を掲載する</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('car_manager.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>掲載車両一覧</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('order.sell') }}" class="flex justify-between bg-white px-6 py-3 border"><span>在庫確認・商談申込受付状況</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('chat.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>チャット</span><i class="fa fa-angle-right fa-fw"></i></a>
        </div>
    </div>
    <div>
        <div class="flex flex-col">
            <a href="{{ route('notification.index') }}" class="flex justify-between bg-white px-6 py-3 border"><span>お知らせ</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('account.show') }}" class="flex justify-between bg-white px-6 py-3 border"><span>会員情報</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('account.edit_password') }}" class="flex justify-between bg-white px-6 py-3 border"><span>パスワード変更</span><i class="fa fa-angle-right fa-fw"></i></a>
            <a href="{{ route('logout') }}" class="flex justify-between bg-white px-6 py-3 border"><span>ログアウト</span><i class="fa fa-angle-right fa-fw"></i></a>
        </div>
    </div>
</div>
