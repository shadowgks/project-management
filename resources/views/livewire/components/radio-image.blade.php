<div {{ $class == null ? '' : 'class=' . $class }} {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <label class="form-check-image active">
        <div class="form-check-wrapper">
            <img {{ $src == null ? '' : 'src=' . $src }} />
        </div>

        <div class="form-check form-check-custom form-check-solid">
            <input class="form-check-input {{ $inputClass }}" type="radio" {{ $_id == null ? '' : 'id=' . $_id }} {{ $name == null ? '' : 'name=' . $name }} {{ $value == null ? '' : 'value=' . $value }} {{ $model == null ? '' : 'wire:model=_value' }} {{ $change == null ? '' : 'wire:change=' . $change }} />
            <div class="form-check-label {{ $labelClass }}" {{ $_id == null ? '' : 'for=' . $_id }}>
                {{ $label }}
            </div>
        </div>
    </label>
</div>