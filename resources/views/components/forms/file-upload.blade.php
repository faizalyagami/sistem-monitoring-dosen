@props(['name', 'label', 'file' => null, 'accept' => 'image/*', 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-bold">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @if ($file)
        <div class="mb-2">
            <img src="{{ Storage::url($file) }}" class="img-thumbnail" width="150" alt="Current photo">
            <small class="d-block text-muted">File saat ini</small>
        </div>
    @endif

    <input type="file" name="{{ $name }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" accept="{{ $accept }}" {{ $attributes }}
        {{ $required ? 'required' : '' }}>

    <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>

    <div id="preview-{{ $name }}" class="mt-2"></div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script>
        // Preview image before upload
        document.getElementById('{{ $name }}')?.addEventListener('change', function(e) {
            const preview = document.getElementById('preview-{{ $name }}');
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" class="img-thumbnail" width="150">`;
                };
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
@endpush
