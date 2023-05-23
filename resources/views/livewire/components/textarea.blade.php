<div class="fv-row mb-5{{ $class == null ? '' : ' ' . $class }}" {!! $_key == null ? '' : 'wire:key="' . $_key . '"' !!}>
    @if ($label != null)
        <label {!! $_id == null ? '' : 'for="' . $_id . '"' !!}
            class="d-flex align-items-center fs-5 fw-semibold mb-2{{ $labelClass == null ? '' : ' ' . $labelClass }}">
            <span
                class="{{ $required != null && ($required == true || $required == 'true') ? 'required' : '' }}">{{ $label }}</span>
        </label>
    @endif
    <textarea class="form-control
            form-control-lg form-control-solid {{ $inputClass }}" {!! $_id == null ? '' : 'id="' . $_id . '"' !!}
        {!! $name == null ? '' : 'name="' . $name . '"' !!} rows="{{ $rows }}" {!! $cols == null ? '' : 'cols="' . $cols . '"' !!} {!! $model == null ? '' : 'wire:model="' . $model . '"' !!}
        onchange="liveSetModel(this)" {!! $change == null ? '' : 'wire:change="' . $change . '"' !!}></textarea>
</div>
