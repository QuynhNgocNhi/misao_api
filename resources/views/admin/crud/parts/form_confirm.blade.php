@if($item ?? false)
    {{ Form::hidden($item->getKeyName(), $item->getKey()) }}
@endif
<div class="crud-edit-form">
    @foreach ($formList as $formKey => $form)
        @if ($form['type'] == 'hidden')
            {{ Form::hidden($formKey, request()->input($formKey) ?? $item->{$formKey} ?? '') }}
            @continue
        @endif

        <div class="row {{ ($form['no_border'] ?? false) ? '' : 'border-bottom' }} {{ $form['row_class'] ?? '' }}">
            <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                {{$form['label']}}
            </div>
            <div class="col-md-9 col-sm-12 p-2">
                @if ($form['read_only'] ?? false)
                    @if (isset($form['values']))
                        {{ $form['values'][$item->{$formKey}] ?? '' }}
                    @else
                        {!! $item->{$formKey} ?? request()->get($formKey) ?? '' !!}
                    @endif

                @elseif ($form['type'] == 'select')
                    {{-- SELECT --}}
                    {{ $form['values'][request()->get($formKey)] ?? '' }}

                @elseif ($form['type'] == 'select_multi')
                    {{-- SELECT MULTI --}}
                    @foreach ((request()->get($formKey) ?? []) as $v)
                        {{ $form['values'][$v] ?? '' }}<br>
                    @endforeach

                @elseif ($form['type'] == 'radio')
                    {{-- RADIO --}}
                    {{ $form['values'][request()->get($formKey)] ?? '' }}

                @elseif ($form['type'] == 'checkbox')
                    {{-- CHECKBOX --}}
                    @if (!empty(request()->get($formKey)))
                        @foreach (request()->get($formKey) as $value)
                            {{ $form['values'][$value] ?? '' }}<br/>
                        @endforeach
                    @endif

                @elseif ($form['type'] == 'textarea')
                    {{-- TEXT AREA --}}
                    {{-- {{ nl2br(request()->get($formKey)) }} --}}
                    {!! nl2br(request()->get($formKey)) !!}

                @elseif ($form['type'] == 'number')
                    {{-- NUMBER --}}
                    {{ number_format(request()->get($formKey)) }}

                @elseif ($form['type'] == 'file')
                    {{-- FILE --}}
                    @if ($tempFile = request()->get($formKey . '_file' , null))
                        @if (str_contains($tempFile['mime_type'], 'image/'))
                            <img src="{{ $tempFile['preview_url'] }}" alt="" style="max-width: 350px;"
                                 class="w-100 mt-3"/><br>
                        @endif
                        {{ $tempFile['file_name'] }}
                        {{ Form::hidden($formKey . '_file', $tempFile['path']) }}
                    @endif

                @elseif ($form['type'] == 'password')
                    {{-- PASSWORD --}}
                    ********

                @elseif ($form['type'] == 'full_name')
                    {{-- PASSWORD --}}
                    {{ request()->get('first_'.$formKey) .' ' . request()->get('last_'.$formKey)}}

                @else
                    {{ request()->get($formKey) }}
                @endif
            </div>
        </div>
    @endforeach
</div>
@foreach ($formList as $formKey => $form)
    @if($form['type'] == 'full_name')
        {{ Form::hidden('first_' . $formKey, request()->get('first_' . $formKey)) }}
        {{ Form::hidden('last_' . $formKey, request()->get('last_' . $formKey)) }}
    @endif
    @if($form['type'] == 'checkbox')
        @foreach (request()->get($formKey) as $checkKey => $checkValue)
            <div class="d-none">
                {{ Form::checkbox($formKey . '[]', $checkValue, ['id' => $formKey . '_' . $checkKey]) }}
            </div>
        @endforeach
    @else
        {{ Form::hidden($formKey, request()->get($formKey)) }}
    @endif
@endforeach

