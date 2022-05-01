@foreach (['info', 'success', 'danger', 'warning'] as $msg)
    @if (Session::has('system.message.' . $msg))
        <div class="col-sm-12 mt-3">
            <span class="alert alert-{{$msg}} alert-dismissible fade show d-block text-left">
                {{ Session::get('system.message.' . $msg) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
                    <span>&times;</span>
                </button>
            </span>
        </div>
    @endif
@endforeach
