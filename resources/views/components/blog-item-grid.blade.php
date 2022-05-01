<div class="col-span-1 grid grid-cols-1 lg:grid-cols-1 gap-1 lg:gap-0 relative transition duration-300 rounded-none">
    <div class="max-w-sm overflow-hidden hover:text-blue-500">
        <a class="lg:col-span-1" href="{{ $link = route('blog.show', $post->id) }}" title="{{ $post->title }}">
            <img loading="lazy" class="object-cover w-full h-[145px] md:h-[148px] lg:h-[170px]" src="{{ asset($post->image_path) }}" alt="{{ $post->title }}">
        </a>
        @if(\Illuminate\Support\Carbon::now()->subDays(2) <= $post->publish_at)
            <p class="text-xs bg-red-600 absolute top-0 left-0 py-1 px-2 text-white font-light">NEW</p>
        @endif
        <div class="mt-3 mb-1">
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['tag' => $tag->id]) }}" title="{{ $tag->name }}"
                   class="inline-block border-2 rounded text-blue-500 border-blue-500 px-2 py-1 text-xs text-gray-700 mr-1 mb-1">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
        <a class="lg:col-span-1 h-28 md:h-44" href="{{ $link = route('blog.show', $post->id) }}" title="{{ $post->title }}">
            <div class="text-sm mb-2 line-clamp-2">
                {{ $post->title }}
            </div>
            <p class="text-xs text-gray-500">
                {{ $post->publish_at ? $post->publish_at->toDateString() : $post->created_at->toDateString() }}
            </p>
        </a>
    </div>
</div>
