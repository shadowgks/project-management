<div class="card shadow-sm {{ $class }}" {{ $_id == null ? '' : 'id=' . $_id }} {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    {!! $content !!}
    {{-- {{ $content }} --}}
</div>

