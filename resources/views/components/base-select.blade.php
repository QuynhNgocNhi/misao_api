@if($type === 'vertical')
    <div class="relative inline-block w-full !text-gray-700">
        <div class="block !text-gray-700 mb-2">{{ $label }}</div>
        <select name="{{ $name }}" class="{{ empty(request($name)) ? 'text-gray-400' : '' }} select select-bordered w-full rounded bg-white border-gray-100 font-light js-select-change">
            <option value="">{{ $placeholder }}</option>
            @foreach($items as $key => $value)
                <option value="{{ $key }}" {{ request($name) == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@elseif($type === 'horizontal-close')
    <div class="inline-flex items-center !text-gray-700">
        <div class="whitespace-nowrap !text-gray-700 mr-2">{{ $label }}</div>
        <select name="{{ $name }}" class="{{ empty(request($name)) ? 'text-black' : '' }} min-w-[250px] shadow-lg select select-bordered rounded bg-white border-gray-100 font-light js-select-change">
            <option value="">{{ $placeholder }}</option>
            @foreach($items as $key => $value)
                <option value="{{ $key }}" {{ request($name) == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@else
    <div class="grid grid-cols-12 gap-4 {{ $classWrap }}">
        <label class="pt-3.5 {{ $classLabel }}">
            <span>{{ $label }}</span>
            @if($require)
                <span class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
            @endif
        </label>
        <div class="{{ $classInput }}">
            <select name="{{ $name }}" class="select select-bordered w-full rounded bg-white border-gray-200 text-gray-400 font-light js-select-change">
                <option value="">{{ $placeholder }}</option>
                @foreach($items as $key => $value)
                    <option value="{{ $key }}" {{ request($name) == $key ? 'selected' : null }}>{{ $value }}</option>
                @endforeach
            </select>
            @if($hint)
                <span class="text-sm text-gray-600">{!! $hint !!}</span>
            @endif
        </div>
    </div>
@endif
