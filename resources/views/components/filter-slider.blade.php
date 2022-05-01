<div class="collapse collapse-arrow">
    <input type="checkbox" checked>
    <div class="collapse-title text-sm !bg-white after:top-[0.9rem]">{{ $label ?? '' }}</div>
    <div class="collapse-content !bg-white box-filter">
        @php
            $value = request($name) ? explode(',', request($name)) : [];
            $min_current = $value[0] ?? $min;
            $max_current = $value[1] ?? $max;

            // handle display year
            if($name == 'model_year'){
                $unit_min = '('. japan_year_with_name($min_current) . ')' . $unit;
                $unit_max = '('. japan_year_with_name($max_current) . ')' . $unit;
            }else{
                $unit_min = $unit;
                $unit_max = $unit;
            }
        @endphp
        <div class="text-xs mb-4"><span>{{ $min_current }}</span>{{ $unit_min }} -
            <span>{{ $max_current }}</span>{{ $unit_max }}
        </div>
        <input type="hidden" name="{{ $name }}" value="{{ request($name) }}">
        <div class="slider mx-2.5 w-11/12 ml-[15px] lg:ml-0 lg:mr-0" data-min="{{ $min }}" data-max="{{ $max }}" data-name="{{ $name }}"
             data-min-current="{{ $min_current }}" data-max-current="{{ $max_current }}"></div>
    </div>
</div>
