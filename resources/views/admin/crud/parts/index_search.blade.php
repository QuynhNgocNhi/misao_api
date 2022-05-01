@foreach ($searchList as $searchKey => $search)
    @php($search['type'] = $search['type'] ?? 'text')
    @continue($search['type'] === 'hidden')
    <div class="col-md-{{ $search['grid_size'] ?? '6' }} border-bottom pt-2">
        <div class="form-group crud-search-form">
            <label>{{ $search['label'] }}</label>
            <div class="d-flex">
                @if ($search['type'] == 'dateFromTo')
                    {{-- DATE FROM TO --}}
                    <div class="form-inline">
                        {{ Form::date($searchKey . 'From', Request::get($searchKey . 'From'), ['class' => 'form-control search-form-control'  ]) }}
                        <span class="ml-2 mr-2">〜</span>
                        {{ Form::date($searchKey . 'To', Request::get($searchKey . 'To'), ['class' => 'form-control search-form-control'  ]) }}
                    </div>

                @elseif ($search['type'] == 'dateTo')
                    {{-- DATE TO --}}
                    <div class="form-inline">
                        {{ Form::date($searchKey . 'To', Request::get($searchKey . 'To'), ['class' => 'form-control search-form-control'  ]) }}
                    </div>

                @elseif ($search['type'] == 'dateFrom')
                    {{-- DATE FROM --}}
                    <div class="form-inline">
                        {{ Form::date($searchKey . 'From', Request::get($searchKey . 'From'), ['class' => 'form-control search-form-control'  ]) }}
                    </div>

                @elseif ($search['type'] == 'month')
                    {{-- MONTH --}}
                    {{ Form::input('month', $searchKey, Request::get($searchKey), ['class' => 'form-control search-form-control']) }}

                @elseif ($search['type'] == 'checkbox')
                    {{-- CHECKBOX --}}
                    @foreach ($search['values'] as $key => $value)
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                {{ Form::checkbox($searchKey . '[]', $key, (in_array($key, Request::get($searchKey) ?? [])), ['class' => 'form-check-input search-form-control']) }}
                                {{ $value }}
                            </label>
                        </div>
                    @endforeach

                @elseif ($search['type'] == 'radio')
                    {{-- RADIO --}}
                    @foreach ($search['values'] as $key => $value)
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                @if ($key === '')
                                    {{ Form::radio($searchKey, $key, is_null(Request::get($searchKey)), ['class' => 'form-check-input search-form-control']) }}
                                @else
                                    {{ Form::radio($searchKey, $key, (!is_null(Request::get($searchKey)) && Request::get($searchKey) == $key), ['class' => 'form-check-input search-form-control']) }}
                                @endif
                                {{ $value }}
                            </label>
                        </div>
                    @endforeach

                @elseif ($search['type'] == 'select')
                    {{-- SELECT --}}
                    <div class="form-check form-check-inline">
                        {{ Form::select($searchKey, $search['values'], Request::get($searchKey), ['class' => 'form-control search-form-control', 'placeholder' => '選択してください']) }}
                    </div>

                @else
                    {{ Form::text($searchKey, Request::get($searchKey), ['class' => 'form-control search-form-control']) }}
                @endif
            </div>
        </div>
    </div>
@endforeach
