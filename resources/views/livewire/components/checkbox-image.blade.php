<div {{ $class == null ? '' : 'class=' . $class }} {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <label class="form-check-clip">
        <input class="btn-check {{ $inputClass }}" type="checkbox" {{ $_id == null ? '' : 'id=' . $_id }} {{ $name == null ? '' : 'name=' . $name }} {{ $value == null ? '' : 'value=' . $value }} {{ $model == null ? '' : 'wire:model=_value' }} {{ $change == null ? '' : 'wire:change=' . $change }} />
        <div class="form-check-wrapper">
            <div class="form-check-indicator"></div>
            <img class="form-check-content" {{ $src == null ? '' : 'src=' . $src }} />
        </div>

        <div class="form-check-label {{ $labelClass }}" {{ $_id == null ? '' : 'for=' . $_id }}>
            {{ $label }}
        </div>
    </label>
</div>