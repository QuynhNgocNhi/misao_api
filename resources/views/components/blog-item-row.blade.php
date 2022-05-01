<div class="col-span-1 relative mb-2">
    <a class="lg:col-span-1" href="{{ $link = route('blog.show', $post->id) }}" title="{{ $post->title }}">
        <img loading="lazy" class="object-cover w-full h-[145px] md:h-[148px] lg:h-[170px]" src="{{ asset($post->image_path) }}" alt="{{ $post->title }}">
    </a>
    @if(\Illuminate\Support\Carbon::now()->subDays(2) <= $post->publish_at)
        <p class="text-xs bg-red-600 absolute top-0 left-0 py-1 px-2 text-white font-light">NEW</p>
    @endif
</div>
<div class="col-span-1 mb-2 hover:text-blue-500">
    <a href="{{ $link = route('blog.show', $post->id) }}" title="{{ $post->title }}">
        <div class="text-sm mb-2 line-clamp-2">
            {{ $post->title }}
        </div>
        <div class="mt-3 mb-1">
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['tag' => $tag->id]) }}" title="{{ $tag->name }}"
                   class="inline-block border-2 rounded text-blue-500 border-blue-500 px-2 py-1 text-xs mr-1 mb-1">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
        <p class="text-xs text-gray-500">
            {{ $post->publish_at->toDateString() }}
        </p>
    </a>
</div>
