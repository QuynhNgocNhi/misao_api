<div class="grid grid-cols-12 gap-4 {{ $classWrap }}">
    <label class="pt-3.5 {{ $classLabel }}">
        <span>{{ $label }}</span>
        @if($require)
            <span class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
        @endif
    </label>
    <div class="{{ $classInput }}">
        <input class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded focus:shadow-outline"
               type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $value }}" @if($disabled) disabled @endif/>
        @if($hint)
            <span class="text-sm text-gray-400">{!! $hint !!}</span>
        @endif
    </div>
</div>
