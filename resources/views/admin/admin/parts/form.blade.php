@if($item ?? false)
    {{ Form::hidden($item->getKeyName(), $item->getKey()) }}
@endif
@foreach ($formList as $formKey => $form)
    @if ($form['type'] == 'hidden')
        {{ Form::hidden($formKey, $form['value'] ?? request()->input($formKey) ?? $item->{$formKey} ?? '') }}
        @continue
    @endif

    <div class="row {{ ($form['no_border'] ?? false) ? '' : 'border-bottom' }} {{ $form['row_class'] ?? '' }}">
        <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
            {{ $form['label'] }}
            @if (($form['required'] ?? false) || ($form['required_badge'] ?? false))
                <div class="badge badge-danger pull-right ml-2">必須</div>
            @endif
        </div>
        <div class="col-md-9 col-sm-12 p-2">
            @if ($form['read_only'] ?? false)
                {{-- READ ONLY --}}
                @if ($item)
                    @if (isset($form['values']))
                        {{ $form['values'][$item->{$formKey}] ?? '' }}
                    @else
                        {{ request()->input($formKey) ?? $item->{$formKey} ?? '' }}
                    @endif
                @else
                    {{ request()->input($formKey) }}
                @endif

            @elseif ($form['type'] == 'select')
                {{-- SELECT --}}
                {{ Form::select($formKey, $form['values'], request()->input($formKey) ?? $item->{$formKey} ?? '',
                    ['class' => $form['class'] ?? 'form-control', 'placeholder' => '選択してください']) }}

            @elseif ($form['type'] == 'select_multi')
                {{-- SELECT MULTI --}}
                {{ Form::select($formKey . '[]', $form['values'], request()->input($formKey) ?? $item->{$formKey} ?? [],
                    ['class' => $form['class'] ?? 'form-control', 'size' => 5, 'multiple']) }}

            @elseif($form['type'] == 'checkbox')
                {{-- CHECK BOX --}}
                @foreach ($form['values'] as $checkKey => $checkValue)
                    @php
                        $oldValues = request()->input($formKey) ?? $item->{$formKey} ?? '';
                        $oldValues = is_array($oldValues) ? $oldValues : explode(",", $oldValues);
                    @endphp
                    <div class="form-check form-check-inline">
                        {{ Form::checkbox($formKey . '[]', $checkKey, in_array($checkKey, $oldValues),
                            ['id' => $formKey . '_' . $checkKey, 'class' => 'form-check-input']) }}
                        <label class="form-check-label" for="{{ $formKey . '_' . $checkKey }}">{{ $checkValue }}</label>
                    </div>
                @endforeach

            @elseif($form['type'] == 'radio')
                {{-- RADIO --}}
                @foreach ($form['values'] as $radioKey => $radioValue)
                    <div class="form-check form-check-inline">
                        {{ Form::radio($formKey, $radioKey, (request()->input($formKey) ?? $item->{$formKey} ?? '') == $radioKey,
                                             ['id' => $formKey . '_' . $radioKey, 'class' => 'form-check-input']) }}
                        <label class="form-check-label" for="{{ $formKey . '_' . $radioKey }}">{{ $radioValue }}</label>
                    </div>
                @endforeach

            @elseif ($form['type'] == 'date' || $form['type'] == 'datetime')
                {{-- DATE TIME --}}
                @php
                    $oldValue = request()->input($formKey) ?? $item->{$formKey} ?? '';
                    if (strlen($oldValue) > 0) {
                        $format = $form['type'] == 'date' ? 'Y-m-d' : 'Y-m-d\TH:i:s';
                        $oldValue = date($format, strtotime($oldValue));

                    }
                @endphp
                @if($form['type'] == 'date')
                    {{ Form::date($formKey, $oldValue, ['class' => $form['class'] ?? 'form-control'  ]) }}
                @else
                    {{ Form::input('dateTime-local', $formKey, $oldValue, ['class' => $form['class'] ?? 'form-control'  ]) }}
                @endif

            @elseif ($form['type'] == 'textarea')
                {{-- TEXTAREA --}}
                {{ Form::textarea($formKey, request()->input($formKey) ?? $item->{$formKey} ?? '', ['class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}

            @elseif ($form['type'] == 'number')
                {{-- NUMBER --}}
                {{ Form::number($formKey, request()->input($formKey) ?? $item->{$formKey} ?? '', ['min' => 0, 'class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}

            @elseif ($form['type'] == 'email')
                {{-- EMAIL --}}
                {{ Form::email($formKey, request()->input($formKey) ?? $item->{$formKey} ?? '', ['class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}

            @elseif ($form['type'] == 'password')
                {{-- PASSWORD --}}
                {{ Form::password($formKey, ['class' => $form['class'] ?? 'form-control', 'placeholder' => '********']) }} 

            @elseif ($form['type'] == 'file')
                {{-- FILE --}}
                <div class="d-block">
                    {{ Form::file($formKey, ['class' => ($form['class'] ?? ''), 'accept' => ($form['accept'] ?? '*')]) }}
                    @if (isset($item) && $item->{$formKey})
                        <br/>
                        @if (isset($form['accept']) && $form['accept'] === 'image/*')
                            <img src="{{ $item->{$formKey} }}" alt="" style="max-width: 350px;" class="w-100 mt-3"/>
                        @else
                            <a href="{{ $item->{$formKey} }}" download
                               target="_blank">{{ $item->{str_replace("file_data", "file_name", $formKey)} }}</a>
                        @endif
                    @endif
                </div>

            @elseif ($form['type'] == 'full_name')
                {{-- FULL NAME --}}
                @php($firstNameKey = 'first_' . $formKey)
                @php($lastNameKey = 'last_' . $formKey)
                <div class="form-inline">
                    {{ Form::text($firstNameKey, request()->input($firstNameKey) ?? $item->{$firstNameKey} ?? '', ['class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}
                    <span class="ml-2 mr-2">〜</span>
                    {{ Form::text($lastNameKey, request()->input($lastNameKey) ?? $item->{$lastNameKey} ?? '', ['class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}
                </div>
                @include('admin.crud.parts.input_error',['name' => $firstNameKey])
                @include('admin.crud.parts.input_error',['name' => $lastNameKey])
            @else
                {{-- TEXT --}}
                {{ Form::text($formKey, request()->input($formKey) ?? $item->{$formKey} ?? '', ['class' => $form['class'] ?? 'form-control', 'placeholder' => $form['placeholder'] ?? '']) }}
            @endif

            @if($form['help'] ?? false)
                <small class="form-text">{{ $form['help'] }}</small>
            @endif

            @include('admin.crud.parts.input_error',['name' => $formKey])
        </div>
    </div>
@endforeach
