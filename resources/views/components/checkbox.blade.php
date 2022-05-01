<label class="cursor-pointer label justify-start">
    <input type="checkbox" name="{{ $name }}" value="{{ $key }}" {{ $active ? 'checked' : '' }}
    class="checkbox checkbox-filter checkbox-sm">
    <span class="label-text !text-slate-700 ml-2 line-clamp-1">{{ $value }}</span>
</label>
