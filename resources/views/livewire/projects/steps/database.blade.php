<div class="fv-row mb-10 fv-plugins-icon-container">
    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
        <span>DB name</span>
    </label>
    <input type="text" class="form-control form-control-lg form-control-solid" wire:model="data.values.db_name">
</div>

<div class="fv-row mb-10 fv-plugins-icon-container">
    @foreach ($data['tables'] as $table)
        <div class="form-check form-check-click col-md-4 mb-3" wire:key="table-{{ $table['id'] }}">
            <input class="form-check-input mt-2" type="checkbox" value="{{ $table['id'] }}"
                id="table-{{ $table['id'] }}" wire:model="data.values.tables" />
            <label class="form-check-label" for="table-{{ $table['id'] }}">
                <span class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $table['name'] }}</span>
            </label>
        </div>
    @endforeach
</div>
