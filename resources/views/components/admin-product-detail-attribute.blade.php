@props([
    'label', 'value',
    'labelClass' => 'col-2',
    'valueClass' => 'col-4'
])

<div class="{{ $labelClass }} p-2 border bg-light font-medium">
    <span class="label-input">{{ $label }}</span>
</div>
<div class="{{ $valueClass }} p-2 border">{{ $value }}</div>
