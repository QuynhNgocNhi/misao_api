@if (isset($breadcrumbs) && $breadcrumbs)
    <div class="px-4 text-xs breadcrumbs text-gray-400 border-t border-b border-gray-50 font-light">
        <ul>
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!is_null($breadcrumb->url) && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="breadcrumb-item active text-black">{{ $breadcrumb->title }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@else
    <div class="px-4 text-xs breadcrumbs text-gray-400 border-t border-b border-gray-50 font-light">
        <ul>
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Documents</a>
            </li>
            <li class="text-black">Add Document</li>
        </ul>
    </div>
@endif
