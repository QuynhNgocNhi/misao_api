@if (sizeof($items) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover table-sort">
            <thead>
            <tr>
                @if ($canSelectAll)
                    <th class="text-center text-nowrap">
                        対象
                        <br><input type="checkbox" id="all-check-box">
                    </th>
                @endif

                @php( $sort = request()->get('sort', ''))
                @php( $dir = request()->get('dir', 'asc'))
                @foreach ($tableList as $columnKey => $column)
                    <?php
                    $canSort = ($column['sort'] ?? true);
                    if ($columnKey === 'button') {
                        $canSort = false;
                    }
                    $classSort = $canSort ? 'sorting ' : '';
                    $innerDir = '';
                    $sort_key = isset($column['sort_key']) ? $column['sort_key'] : $columnKey;
                    if ($sort == $sort_key) {
                        if ($dir === 'asc') {
                            $innerDir = 'desc';
                            $classSort .= 'sorting_asc';
                        } else if ($dir === 'desc') {
                            $innerDir = '';
                            $classSort .= 'sorting_desc';
                        } else {
                            $innerDir = 'asc';
                        }
                    } else {
                        $innerDir = 'asc';
                    }
                    ?>
                    <th class="text-center text-nowrap {{ $classSort }}">
                        @if($canSort)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $sort_key, 'dir' => $innerDir]) }}">{{ $column['label'] ?? ''}}</a>
                        @else
                            {{ $column['label'] ?? ''}}
                        @endif

                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr class="{{ $item->row_class }}">
                    @if ($canSelectAll)
                        <td class="text-center">
                            <input type="checkbox" name="ids[]" value="{{ $item->getKey() }}"
                                   class="all-check-box-item">
                        </td>
                    @endif
                    @foreach ($tableList as $columnKey => $column)
                        @php($column['type'] = $column['type'] ?? '')
                        @php( $attrName = $columnKey)
                        @if($column['attribute_name'] ?? false)
                            @php( $attrName = $column['attribute_name'])
                        @endif
                        @php($value = $item->{$attrName} ?? '')
                        @if(!empty($column['relate']))
                            @php($value = \Illuminate\Support\Arr::get($item, $column['relate'] . '.' . $attrName))
                        @endif
                        <td class="text-center position-relative overflow-hidden text-truncate {{ $column['text_wrap'] ?? 'text-nowrap' }}" style="max-width: 300px">
                            {{ $column['prefix'] ?? '' }}

                            @if (isset($column['render']))
                                {{-- special render --}}
                                @if(is_callable($column['render']))
                                    {{ $column['render']($item) }}
                                @else
                                    {{ $column['render'] ?? '' }}
                                @endif

                            @elseif (isset($column['button']))

                                @foreach ($column['button'] as $button)
                                    <?php
                                    if (($button['exclude'] ?? false) && in_array($item->getKey(), $button['exclude'])) {
                                        continue;
                                    }

                                    $url = 'javascript:void(0)';
                                    $class = $button['class'] ?? '';
                                    $action = $button['action'] ?? false;
                                    switch ($action) {
                                        case 'detail':
                                        case 'show':
                                        case 'edit':
                                            if ($routeList[$action] ?? false) {
                                                $url = route($routeList[$action], $item->getKey());
                                            }
                                            break;
                                        case 'destroy':
                                            $class .= ' crud-index-table-delete';
                                            if ($routeList['destroy'] ?? false) {
                                                $url = route($routeList['destroy'], $item->getKey());
                                            }
                                        default:
                                            break;
                                    }
                                    ?>
                                    @if($action != 'destroy' || !$url)
                                        <a href="{{ $url }}" class="btn btn-primary mr-2 {{ $class }}"
                                           id="{{ $button['id'] ?? ''}}" data-id="{{ $item->getKey() }}">
                                            {{ $button['label'] ?? '' }}
                                        </a>
                                    @else
                                        {!! Form::open(['url' => $url, 'method' => 'DELETE', 'class' => 'd-inline-block']) !!}
                                        <button type="submit" class="btn btn-primary mr-2 {{ $class }}"
                                                id="{{ $button['id'] ?? ''}}" data-id="{{ $item->getKey() }}">
                                            {{ $button['label'] ?? '' }}
                                        </button>
                                        {!! Form::close() !!}
                                    @endif
                                @endforeach

                            @elseif ($column['type'] == 'date' || $column['type'] == 'datetime')
                                {{-- DATE - DATETIME --}}
                                {{ !empty($value) ? date($column['format'] ?? ($column['type'] == 'datetime' ? 'Y-m-d H:i:s' : 'Y-m-d'), strtotime($value)) : $value }}


                            @elseif(($column['type']) == 'number')
                                {{ is_numeric($value) ? number_format($value) : $value }}

                            @elseif(in_array($column['type'], ['checkbox', 'select', 'radio']))
                                {{ $column['values'][$value] ?? $value ??'' }}

                            @else
                                {{ $value }}
                            @endif

                            {{ $column['suffix'] ?? '' }}

                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $items->onEachSide(0)->appends(Request::except('_token'))->links('admin.block.paginator') !!}
    </div>
@else
    <h5 class="text-center">{{ $modelLabel ?? ''}} 該当するデータが見つかりませんでした。</h5>
@endif
