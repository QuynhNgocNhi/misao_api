@props(['label', 'value', 'suffix' => '', 'classMore' => '', 'type' => 'normal'])
@if($type === 'normal')
    <div class="flex flex-row md:flex-col items-center">
        <span class="bg-white md:bg-slate-200 w-[80px] md:w-full text-center p-1 md:p-0 mr-2 text-slate-700 text-sm md:text-sm mb-0.5 md:mb-1 {{ $classMore }}">{{ $label }}</span>
        <span class="text-sm md:text-xl font-bold mr-1 md:mb-1">{{ $value }}</span>
        <span class="text-xs md:text-sm font-light">{{ $suffix }}</span>
    </div>
@elseif($type === 'grid')
    <div class="flex gap-3 md:justify-between mb-1">
        <span class="bg-slate-200 w-[70px] md:w-[83px] px-2 py-1 text-slate-700 text-[10px] md:text-xs mb-0.5">{{ $label }}</span>
        <span class="text-xs md:text-base font-light"><span class="font-bold md:font-normal">{{ $value }}</span> {{ $suffix }}</span>
    </div>
@endif
