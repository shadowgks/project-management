<div class="fv-row mb-10 fv-plugins-icon-container">
    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
        <span>{{ __('Project name') }}</span>
    </label>
    <input type="text" class="form-control form-control-lg form-control-solid" wire:model="data.values.project_name">
</div>

<div class="fv-row mb-10 fv-plugins-icon-container">
    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
        <span>{{ __('Description') }}</span>
    </label>
    <textarea class="form-control form-control-lg form-control-solid" rows="6" wire:model="data.values.description"></textarea>
</div>

<div class="fv-row mb-10 fv-plugins-icon-container">
    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
        <span>{{ __('Project name') }}</span>
    </label>
    <div class="d-flex flex-row">
        <div class="form-check me-2">
            <input class="form-check-input" type="radio" id="date-saas-no" value="no"
                wire:model="data.values.saas">
            <label class="form-check-label" for="date-saas-no">{{ __('No') }}</label>
        </div>
        <div class="form-check me-2">
            <input class="form-check-input" type="radio" id="date-saas-yes" value="yes"
                wire:model="data.values.saas">
            <label class="form-check-label" for="date-saas-yes">{{ __('Yes') }}</label>
        </div>
    </div>
</div>

<div class="fv-row">
    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
        <span>{{ __('Template') }}</span>
    </label>
    <select name="template" class="form-select" id="template" wire:model="data.values.template">
        <option value=""></option>
        @foreach ($data['templates'] as $template)
            <option value="{{ $template['id'] }}">{{ $template['name'] }}</option>
        @endforeach
    </select>
</div>
