<div {!! $class == null ? '' : 'class="' . $class . '"' !!} {!! $_key == null ? '' : 'wire:key="' . $_key . '"' !!}>
    @if ($label != null)
        <label {!! $_id == null ? '' : 'for="' . $_id . '"' !!} {!! $labelClass == null ? '' : 'class="' . $labelClass . '"' !!}>{{ $label }}</label>
    @endif

    <input type="range" class="form-range {{ $inputClass }}" {!! $_id == null ? '' : 'id="' . $_id . '"' !!} {!! $name == null ? '' : 'name="' . $name . '"' !!}
        {!! $model == null ? '' : 'wire:model="' . $model . '"' !!} onchange="liveSetModel(this)" {!! $change == null ? '' : 'wire:change="' . $change . '"' !!} />
</div>
