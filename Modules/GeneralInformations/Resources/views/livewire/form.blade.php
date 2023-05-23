@php
    use App\Helpers\TemplateHelper;
@endphp

<div class="row m-0 {!! $options['show_form'] ? '' : 'hidden' !!}">
    <div class="col-md-3 p-4">
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">{{ __('Menu') }}</h3>
            </div>

            <div class="card-body">
                <div class="row m-0">
                    @foreach ($menuElements as $key => $element)
                        <button
                            class="btn btn-light-primary w-100 mb-2 {{ $key == $options['currentMenuElement'] ? 'active' : '' }}"
                            onclick="loadingVisibility(true)"
                            wire:click="action_menu({{ $key }})">{{ __($element['name']) }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 p-4">
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">{{ $options['id'] == null ? __('New') : __('Edit') }}</h3>
            </div>

            <div class="card-body">
                <div class="row m-0">
{{-- form - start --}}
            <div class="fv-row mb-5 col-md-6" >
                <label for="field-name"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span
                        class="required">{{ __("Name") }}</span>
                </label>

                <input type="text" class="form-control form-control-lg form-control-solid"
                    id="field-name" name="field-name"  maxlength="255"   wire:model.lazy="form.name"
                     />
            </div>
        

                <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container" wire:ignore>
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span class="required">{{ __("Type") }}</span>
                    </label>
                    <select
                        class="form-select select-2-dropdown @error("title") is-invalid @enderror"
                        name="type"
                        wire:model="form.type"
                        
                    >
                        <option value="" disabled>{{ __("Choose") }}</option>
                @foreach($base_data["type_options"] as $dt)<option value="{{ $dt["id"] }}">{{ $dt["text"] }}</option>@endforeach

                   </select>
                </div>

            <div class="fv-row mb-5 col-md-6" >
                <label for="field-start_date"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span
                        class="">{{ __("Start date") }}</span>
                </label>

                <input type="datetime" class="form-control form-control-lg form-control-solid"
                    id="field-start_date" name="field-start_date"     wire:model.lazy="form.start_date"
                     />
            </div>
        

            <div class="fv-row mb-5 col-md-6" >
                <label for="field-finish_date"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span
                        class="">{{ __("Finish date") }}</span>
                </label>

                <input type="datetime" class="form-control form-control-lg form-control-solid"
                    id="field-finish_date" name="field-finish_date"     wire:model.lazy="form.finish_date"
                     />
            </div>
        

            <div class="fv-row mb-5 col-md-12" >
                <label for="field-description"
                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span
                        class="">{{ __("Description") }}</span>
                </label>

                <textarea class="form-control form-control-lg form-control-solid"
                    id="field-description" name="field-description" rows="6"  wire:model.lazy="form.description"
                    ></textarea>
            </div>
        
{{-- form - end --}}
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.includes.base.form-buttons')
