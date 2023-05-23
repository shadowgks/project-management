@php
    use App\Helpers\TemplateHelper;
@endphp

@if ($base_data['permissions']['create'] || $base_data['permissions']['update'])
    <div class="modal black-background-transparent fade {{ $options['show_modal'] ? 'show' : '' }}" id="modal-view"
        tabindex="-1" role="dialog" style="display: {{ $options['show_modal'] ? 'block' : 'none' }}">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ $options['id'] == null ? 'New' : 'Edit' }} Form</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1" wire:click="action_options('show_modal')">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row m-0">
                        {{-- form - start --}}
                        <div class="fv-row mb-5 col-md-6">
                            <label for="field-title" class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Title') }}</span>
                            </label>

                            <input type="text" class="form-control form-control-lg form-control-solid"
                                id="field-title" name="field-title" maxlength="255" wire:model.lazy="form.title" />
                        </div>


                        <div class="fv-row mb-5 col-md-6">
                            <label for="field-start_date" class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="">{{ __('Start date') }}</span>
                            </label>

                            <input type="datetime" class="form-control form-control-lg form-control-solid"
                                id="field-start_date" name="field-start_date" wire:model.lazy="form.start_date" />
                        </div>


                        <div class="fv-row mb-5 col-md-6">
                            <label for="field-end_date" class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="">{{ __('End date') }}</span>
                            </label>

                            <input type="datetime" class="form-control form-control-lg form-control-solid"
                                id="field-end_date" name="field-end_date" wire:model.lazy="form.end_date" />
                        </div>


                        <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container" wire:ignore>
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Priority id') }}</span>
                            </label>
                            <select class="form-select select-2-dropdown @error('title') is-invalid @enderror"
                                name="priority_id" wire:model="form.priority_id">
                                <option value="" disabled>{{ __('Choose') }}</option>
                                @foreach ($base_data['priority_id_options'] as $dt)
                                    <option value="{{ $dt['id'] }}">{{ $dt['text'] }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="fv-row mb-5 col-md-12">
                            <label for="field-description" class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="">{{ __('Description') }}</span>
                            </label>

                            <textarea class="form-control form-control-lg form-control-solid" id="field-description" name="field-description"
                                rows="6" wire:model.lazy="form.description"></textarea>
                        </div>

                        {{-- form - end --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="loadingVisibility(true)"
                        wire:click="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success" onclick="loadingVisibility(true)"
                        wire:click="save">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endif
