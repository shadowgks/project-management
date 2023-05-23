<button type="{{ $type }}" {{ $_id == null ? '' : 'id=' . $_id }} class="btn {{ $class }}" {{ $_key == null ? '' : 'wire:key=' . $_key }} {{ $click == null ? '' : 'wire:click=actionClick' }}>
    <span>{{ $title }}</span>
</button>