@foreach ($formList as $formKey => $form)
    @php($form['type'] = $form['type'] ?? 'text')
    <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
        <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
            {{ $form['label'] ?? '' }}
        </div>
        <div class="col-md-9 col-sm-12 p-2 text-break">
            @if (isset($form['render']))
                {{-- special render --}}
                @if(is_callable($form['render']))
                    {{ $form['render']($item) }}
                @else
                    {{ $form['render'] ?? '' }}
                @endif

            @elseif ($form['type'] == 'select' || $form['type'] == 'radio')
                {{-- SELECT - RADIO --}}
                {{ $form['values'][$item->{$formKey}] ?? '' }}

            @elseif ($form['type'] == 'checkbox')
                {{-- CHECKBOX --}}
                @if (is_array($item->{$formKey}))
                    @foreach ($item->{$formKey} as $itemKey)
                        {{ $form['values'][$itemKey] ?? '' }}<br>
                    @endforeach
                @else
                    {{ $form['values'][$item->{$formKey}] ?? '' }}
                @endif

            @elseif ($form['type'] == 'textarea')
                {{-- TEXTAREA --}}
                {!! isset($item->{$formKey}) ? nl2br(htmlspecialchars($item->{$formKey})) : '' !!}

            @elseif ($form['type'] == 'date' || $form['type'] == 'datetime')
                {{-- DATE - DATETIME --}}
                {{ !empty($item->{$formKey}) ? date($form['format'] ?? ($form['type'] == 'datetime' ? 'Y-m-d H:i:s' : 'Y-m-d'), strtotime($item->{$formKey})) : $item->{$formKey} }}

            @elseif ($form['type'] == 'number')
                {{-- NUMBER --}}
                {{ is_numeric($item->{$formKey} ?? '') ? nl2br(htmlspecialchars($item->{$formKey})) : ($item->{$formKey} ?? '') }}

            @elseif($form['type'] == 'password')
                ********

            @elseif($form['type'] == 'full_name')
            {{ ($item->{'first_'.$formKey} ?? '') .' ' . ($item->{'last_'.$formKey} ?? '') }}

            @elseif($form['type'] == 'html')
                <span style="white-space: pre-wrap">{!! htmlentities($item->{$formKey} ?? '') !!}</span>
            @elseif ($form['relate'] ?? false)
                {{ \Illuminate\Support\Arr::get($item, $form['relate']. '.' . $formKey, '') }}

            @else
                {{ $item->{$formKey} ?? '' }}
            @endif
        </div>
    </div>
@endforeach
