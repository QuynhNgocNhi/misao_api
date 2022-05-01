@props([
    'label', 'value',
    'wrapClass',
    'labelClass',
    'valueClass',
    'oneLine' => false
    ])
@if($oneLine)
    <div class="{{ $wrapClass ?? 'lg:col-span-2 grid grid-cols-1 lg:grid-cols-[157px,1fr]' }} border-b last:border-b-0">
        <span class="{{ $labelClass ?? '' }} p-2 font-medium text-slate-700 bg-slate-200 border-r">{{ $label }}</span>
        <span class="{{ $valueClass ?? '' }} @if(!$value) my-2 @endif p-2 lg:border-r last:border-r-0 whitespace-pre-wrap break-words">{!! $value !!}</span>
    </div>
@else
    <div class="{{ $wrapClass ?? 'grid grid-cols-1 lg:grid-cols-[157px,1fr]' }} border-b last:border-b-0">
        <span class="{{ $labelClass ?? '' }} p-2 font-medium text-slate-700 bg-slate-200 border-r">{{ $label }}</span>
        <span class="{{ $valueClass ?? '' }} @if(!$value) my-2 @endif p-2 lg:border-r last:border-r-0 whitespace-pre-wrap break-words">{!! $value !!}</span>
    </div>
@endif
