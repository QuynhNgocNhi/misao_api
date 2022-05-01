<div class="grid grid-cols-12 gap-4 {{ $classWrap }}">
    <label class="pt-3.5 {{ $classLabel }}">
        <span>{{ $label }}</span>
        @if($require)
            <span class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
        @endif
    </label>
    <div class="{{ $classInput }}">
        <textarea class="form-textarea block w-full resize-none py-3 px-5 rounded bg-white border border-gray-200" rows="{{ $rows }}" placeholder="{{ $placeholder }}">{!! $value !!}</textarea>
        @if($hint)
            <span class="text-sm text-gray-600">{!! $hint !!}</span>
        @endif
    </div>
</div>
