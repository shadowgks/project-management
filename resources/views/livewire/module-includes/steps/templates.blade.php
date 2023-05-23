@php
    use App\Helpers\ModelHelper;
    use App\Helpers\TemplateHelper;
@endphp

<div class="w-100" wire:key="module-template-step-{{ time() }}">
    <div class="row">
        <div class="col-md-4 mb-5 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span class="required">{{ __('Template Type') }}</span>
            </label>
            <select class="form-select form-control-lg form-control-solid" wire:model="values.template.type">
                <option disabled value="">
                    {{ __('Choose Type') }}
                </option>
                @foreach ($base_data['template_types'] as $type)
                    <option value="{{ $type['id'] }}">
                        {{ $type['name'] }}
                    </option>
                @endforeach
            </select>
            {!! TemplateHelper::getFormMessage($options['errors']['template_type']) !!}
        </div>

        @if ($values['template']['type'] == 'separated')
            <div class="col-md-4 mb-5 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">{{ __('Templates') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.template.value">
                    <option disabled value="">
                        {{ __('Choose Template') }}
                    </option>
                    @foreach ($base_data['templates'] as $template)
                        <option value="{{ $template['id'] }}">
                            {{ $template['name'] }}
                        </option>
                    @endforeach
                </select>
                {!! TemplateHelper::getFormMessage($options['errors']['template_value']) !!}
            </div>

            <label class="form-check form-switch form-check-custom form-check-solid mb-3 col-md-3">
                <input class="form-check-input" type="checkbox" wire:model="values.template.cards" />
                <span class="form-check-label fw-semibold text-muted">{{ __('Cards') }}</span>
            </label>

            @if (in_array($values['template']['value'], [2, 3, 4]))
                <div class="row p-0 m-0 mb-5">
                    <span class="fs-3 mb-2">{{ __('Content options') }}</span>
                    <label class="form-check form-switch form-check-custom form-check-solid col-md-3">
                        <input class="form-check-input" type="checkbox"
                            wire:model="values.template.template_content.activate_reminders" />
                        <span class="form-check-label fw-semibold text-muted">{{ __('Reminders') }}</span>
                    </label>

                    <label class="form-check form-switch form-check-custom form-check-solid col-md-3">
                        <input class="form-check-input" type="checkbox"
                            wire:model="values.template.template_content.activate_file_upload" />
                        <span class="form-check-label fw-semibold text-muted">{{ __('Join files') }}</span>
                    </label>

                    <label class="form-check form-switch form-check-custom form-check-solid col-md-3">
                        <input class="form-check-input" type="checkbox"
                            wire:model="values.template.template_content.activate_comments" />
                        <span class="form-check-label fw-semibold text-muted">{{ __('Comments') }}</span>
                    </label>
                </div>
            @endif
        @endif

        <div class="row p-0 m-0 mb-4">
            <span class="fs-3 mb-2">{{ __('Target to save form') }}</span>
            <div class="form-check form-check-custom form-check-solid form-check-sm form-check-primary mb-2">
                <input class="form-check-input" id="target-save-form-db" type="radio" value="db"
                    wire:model="values.template.target_save_fields">
                <label for="target-save-form-db" class="form-check-label text-gray-700">Database</label>
            </div>
            <div class="form-check form-check-custom form-check-solid form-check-sm form-check-primary">
                <input class="form-check-input" id="target-save-form-file" type="radio" value="file"
                    wire:model="values.template.target_save_fields">
                <label for="target-save-form-file" class="form-check-label text-gray-700">File</label>
            </div>
        </div>
    </div>

    {{-- @if ($values['template']['type'] != '')
        @if ($values['template']['type'] == 'global')
            <div class="p-4 mb-4 bg-secondary">
                @include('livewire.templates.global-template')
            </div>
        @else
            @if ($values['template']['value'] != '')
                <div class="p-4 mb-4 bg-secondary">
                    @if ($values['template']['value'] == 1)
                        <livewire:template-demo1 showCards="{{ $values['template']['cards'] }}" />
                    @elseif ($values['template']['value'] == 2)
                        <livewire:template-demo4 showCards="{{ $values['template']['cards'] }}" />
                    @else
                        <livewire:template-demo3 showCards="{{ $values['template']['cards'] }}" />
                    @endif
                </div>
            @endif
        @endif --}}

    @include('livewire.module-includes.steps.layouts.template-add-forms')
    {{-- @endif --}}
</div>
