@if ($withSpace)
    <div class="{{ $spaceClass }}">
@endif

<div class="card card-flush {{ $class }}" {{ $_id == null ? '' : 'id=' . $_id }}
    {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            @if ($value != null)
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $value }}</span>
            @endif

            @if ($title != null)
                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ $title }}</span>
            @endif
        </div>
    </div>

    <div class="card-body d-flex align-items-end pt-0">
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                <span></span>
                @if ($percentage != null)
                    <span>{{ $percentage }}%</span>
                @endif
            </div>

            @if ($percentage != null)
                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                    <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $percentage }}%;"></div>
                </div>
            @endif
        </div>
    </div>
</div>

@if ($withSpace)
    </div>
@endif
