<div class="mb-3">
    <select id="largeSelect" name="{{$name}}" class="form-select form-select-lg">
        <option selected>{{ $label }}</option>
        @if ($options)
            @foreach ($options as $option)
                <option value="{{ $option->id }}" {{ $selected == $option->id ? 'selected' : '' }} >{{ $option->name }}</option>
            @endforeach
        @endif

    </select>
</div>
