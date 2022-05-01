<div class="border border-gray-100 mb-6">
    <div class="p-3 lg:p-5">
        <div class="text-sm leading-relaxed mb-2">
            @if( $order->created_at->diffInDays(now()) < 7)
                <span class="inline-block bg-gray-100 px-2 py-0.5 md:px-4 md:py-1 mr-2 lg:mr-4">新着</span>
            @endif
            <span
                class="inline-block bg-gray-100 px-2 py-0.5 md:px-4 md:py-1">{{ $order->created_at->format('Y年m月d日') }}</span
            ><span class="block lg:inline-block px-2 py-1 md:px-4">{{$order['user']['legal'] ?? ''}}</span>
        </div>
        <p>{{ $order['car']['info'] ?? '' }}</p>
    </div>
    <div class="border-t flex flex-col-reverse gap-2 lg:flex-row justify-between lg:items-center p-3 lg:px-5">
        {!! Form::open(['route' => ['order.delete', $order->id], 'method' => 'POST', 'enctype' => 'multipart/form-data','class'=>'lg:inline-flex']) !!}
        <button class="btn btn-md btn-outline px-16 w-full" type="submit"
                onclick="var cf = confirm('do you want delete');if(!cf) return false;">削除
        </button>
        {!! Form::close() !!}
        <div>
            <a href="{{ route('chat.index', [ 'chat_room_id' => $order->chat_room?->id, 'tab' => TYPE_SELLER ]) }}"
               class="btn btn-md btn-icon px-8 w-full mb-2 lg:w-auto lg:mr-2 lg:mb-0">メッセージ
                <i class="fa fa-arrow-right"></i> </a>
            <a href="{{ route('order.detail', $order->id) }}#update-status"
               class="btn btn-md btn-icon px-8 w-full mb-2 lg:w-auto lg:mr-2 lg:mb-0"> 状況更新 <i class="fa fa-arrow-right"></i> </a>
            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-md btn-icon px-8 w-full lg:w-auto">詳細はこちら
                <i class="fa fa-arrow-right"></i> </a>
        </div>
    </div>

</div>
