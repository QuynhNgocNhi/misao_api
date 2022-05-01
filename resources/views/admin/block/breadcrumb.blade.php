@if (is_array($breadcrumbs ?? null) && count($breadcrumbs))

    <ol class="breadcrumb justify-content-end">
        @foreach ($breadcrumbs as $label => $url)

            @if (!empty($url) && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $label }}</li>
            @endif

        @endforeach
    </ol>

@endif
<style>
    .breadcrumb-item+.breadcrumb-item::before {
        content: ">"
    }
</style>
