@php
    use Carbon\Carbon;
    use App\Helpers\TemplateHelper;
    $time = time();
    $countFormFields = count($values['template']['fields']);
@endphp

<div id="live-component">
    <div class="card card-flush mt-5" id="module">
        <div class="card-body">
            @if ($countFormFields > 0)
                <div class="row">
                    <div class="col-md-4 mb-4 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span>{{ __('Name') }}</span>
                        </label>
                        <input type="text" class="form-control form-control-lg form-control-solid"
                            placeholder="{{ __('Name') }}" wire:model.lazy="values.name">
                        {!! TemplateHelper::getFormMessage($values['errors']['name']) !!}
                    </div>

                    @if (!$options['exception'])
                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Modules') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid" wire:model="values.module"
                                wire:change="get_files">
                                <option disabled value="">{{ __('Choose module') }}</option>
                                @foreach ($base_data['form']['modules'] as $module)
                                    <option value="{{ $module['id'] }}">{{ $module['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if ($values['module'] && !$options['exception'])
                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Files') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid" wire:model="values.file">
                                <option disabled value="">{{ __('Choose file') }}</option>
                                @foreach ($base_data['form']['files'] as $file)
                                    <option value="{{ $file }}">{{ $file }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            @endif

            @include('livewire.module-includes.steps.layouts.template-add-forms')

            @if ($countFormFields > 0)
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-success"
                        wire:click="save_settings">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-danger ms-2" wire:click="clear">{{ __('Cancel') }}</button>
                </div>
            @endif
        </div>
    </div>

    <!-- NOTE - Settings -->
    <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
        route="{{ route($base_data['datatable']['route']) }}" />
</div>
