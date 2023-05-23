<div class="form-check form-switch form-check-custom form-check-solid mb-5 {{ $class }}" {!! $_key == null ? '' : 'wire:key="' . $_key . '"' !!}>
    <input class="form-check-input {{ $inputClass }}" type="checkbox" {!! $_id == null ? '' : 'id="' . $_id . '"' !!} {!! $name == null ? '' : 'name="' . $name . '"' !!}
        {!! $checked != null && ($checked == true || $checked == 'true') ? 'checked' : '' !!} {!! $value == null ? '' : 'value="' . $value . '"' !!} {!! $model == null ? '' : 'wire:model="' . $model . '"' !!} onchange="liveSetModel(this)"
        {!! $change == null ? '' : 'wire:change="' . $change . '"' !!} />
    <label class="form-check-label {{ $labelClass }}" {!! $_id == null ? '' : 'for="' . $_id . '"' !!}>
        {{ $label }}
    </label>
</div>
