<div class="fv-row mb-5{{ $class == null ? '' : ' ' . $class }}" {!! $_key == null ? '' : 'wire:key="' . $_key . '"' !!}>
    @if ($label != null)
        <label {!! $_id == null ? '' : 'for="' . $_id . '"' !!} class="form-label {{ $labelClass }}">{{ $label }}</label>
    @endif

    <select class="form-select select-2-dropdown {{ $selectClass }}" {!! $_id == null ? '' : 'id="' . $_id . '"' !!} {!! $name == null ? '' : 'name="' . $name . '"' !!}
        {!! $placeholder == null ? '' : 'placeholder="' . $placeholder . '"' !!} {!! $multiple != null && ($multiple == true || $multiple == 'true') ? 'multiple' : '' !!} {!! $model == null ? '' : 'wire:model="' . $model . '"' !!} wire:change="setValue">
        <option>{{ $default }}</option>
        @foreach ($data as $dt)
            <option value="{{ $dt[$dataValue] }}">{{ $dt[$dataText] }}</option>
        @endforeach
    </select>
</div>
