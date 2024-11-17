<div class="form-floating mb-3">
    @if ($type == 'file')
        {{-- <div class="mb-3">
            <label for="{{ $name }}" class="form-label">{{ __("home.$label") }}</label>
            <input class="form-control @error($name) is-invalid @enderror" type="file" id="{{ $name }}" name="{{ $name }}" multiple />
        </div> --}}
        <div class="mb-3">
            <label >{{ __("models.$label") }}</label>
            <input type="file"  name="{{ $name }}"  class="form-control @error($name) is-invalid @enderror" id="imageInput" accept="image/*">
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <img id="imagePreview" class="image-preview" src="{{ isset($data)&&$data->img|| isset($data)&&$data->image? image_url($data->img??$data->image) : '' }}"
            alt="Image Preview" style="{{ isset($data)&&$data->img || isset($data)&&$data->image? '' : 'display:none;' }}">
        {{-- <br> --}}
    @elseif($type == 'select')
    <select name="{{ $name }}" id="{{ $name }}" class="form-control">
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>


    @else
        <input type="{{ $type }}" {{@$option}} class="form-control  @error($name) is-invalid @enderror " id="{{ $name }}" placeholder="{{ $placeholder }}"
            aria-describedby="{{ $name }}Help" name="{{ $name }}" value="{{ old($name, $value) }}" />
        <label for="{{ $name }}" class="">{{ __("home.$label") }}</label>
    @endif
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
