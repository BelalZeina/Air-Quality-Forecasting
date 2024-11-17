{{-- components/input.blade.php --}}
<div class="form-group mb-3">
    <label for="{{ $name }}">{{ $label }}</label>

    <div id="{{ $name }}-editor" style="height: 200px;"></div>
    <input type="hidden" name="{{ $name }}"  id="{{ $name }}-hidden">

    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<script>
    // Initialize Quill editor with a more detailed toolbar
    var quill = new Quill('#{{ $name }}-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }], // Headers
                ['bold', 'italic', 'underline'], // Text formatting
                [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                [{ 'color': [] }, { 'background': [] }], // Color options
                [{ 'align': [] }], // Alignment
                ['link', 'image', 'video'], // Links and media
                ['clean'] // Remove formatting button
            ]
        },
    formats: {
        header: true,
        bold: true,
        italic: true,
        underline: true,
        list: 'ordered',
        list: 'bullet',
        align: true, // Enable text alignment
        color: true,
        background: true,
        link: true,
        image: true,
        video: true
    }
    });

    // Set the initial value of the editor
    quill.root.innerHTML = `{!! $value !!}`;

    // Update the hidden input on change
    quill.on('text-change', function() {
        var content = quill.root.innerHTML;
        document.getElementById('{{ $name }}-hidden').value = content;
    });
</script>

