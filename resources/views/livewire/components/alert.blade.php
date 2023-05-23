<div class="alert d-flex align-items-center {{ $class }}" {{ $_id == null ? '' : 'id=' . $_id }} {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">...</span>

    <div class="d-flex flex-column">
        <h4 {{ $titleClass == null ? '' : 'class=' . $titleClass }}>{{ $title }}</h4>
        <span {{ $descriptionClass == null ? '' : 'class=' . $descriptionClass }}>{{ $description }}</span>
    </div>
</div>