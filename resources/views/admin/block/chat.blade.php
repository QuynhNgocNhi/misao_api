<div class="card" id="vue">
    <div class="card-header">
        <div class="col-6 float-left">
            <h4 style=" padding: 0.375rem 0;" class="m-0">メッセージ</h4>
        </div>
        <div class="col-6 float-right text-right">
            @if($url ?? false)
                <a class="btn btn-primary mr-2" href="{{ $url }}">
                    一覧
                </a>
            @endif
        </div>
    </div>
    @if($item ?? false)
        <div class="mr-2 p-2">
            <div class="col-6 float-left">
                買い手： {{ $item->seller->id_name }}
            </div>
            <div class="col-6 float-right text-right">
                売り手：{{ $item->buyer->id_name }}
            </div>
        </div>
        <div class="card-body pb-5">
            <admin-chat-detail :room-info='{!! json_encode(['id' => $item->id, 'car_name'=>'' ]) !!}'>
        </div>
    @else
        <div class="card-body pb-5" style="min-height: 300px">
        </div>
    @endif
</div>

@section('js')
    @parent
    <script src="{{ mix('js/vue.js') }}"></script>
@endSection
