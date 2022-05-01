<div class="collapse collapse-arrow">
    <input type="checkbox" checked>
    <div class="collapse-title text-sm !bg-white after:top-[0.9rem]">{{ $label ?? '' }}</div>
    <div class="collapse-content !bg-white box-filter">
        <div class="{{ $wrapClass }}">
            @php
                $params = request($name) ? explode(',', request($name)) : [];
            @endphp
            @foreach($items as $key => $value)
                <x-checkbox name="{{ $name }}" :key="$key" :value="$value" :active="in_array($key,$params)"/>
            @endforeach
        </div>
    </div>
</div>
