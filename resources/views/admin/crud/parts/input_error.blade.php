@if (count($errors))
    @foreach($errors->get($name) as $message)
        <span class="form-text text-danger">{{ $message }}</span>
    @endforeach
@endif
