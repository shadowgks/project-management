<div>
    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.notification.created">
        <span class="form-check-label fw-semibold text-muted">{{ __('Created') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.notification.edited">
        <span class="form-check-label fw-semibold text-muted">{{ __('Edited') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.notification.deleted">
        <span class="form-check-label fw-semibold text-muted">{{ __('Deleted') }}</span>
    </label>
</div>
