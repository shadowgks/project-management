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
                            class="btn btn-light-primary w-100 mb-2 {{ $key == $options['currentMenuElement'] ? 'active' : '' }} {{ ($key == 1 || $key == 2) && $appOptions['id'] == null ? 'hidden' : '' }}"
                            wire:click="action_menu({{ $key }})">{{ __($element['name']) }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 p-4">
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">{{ $appOptions['id'] == null ? __('New') : __('Edit') }}</h3>

                <div class="card-toolbar">
                    @if ($options['currentMenuElement'] == 1)
                        <button class="btn btn-primary btn-sm"
                            wire:click="action_show_form('company_sites')">{{ __('New site') }}</button>
                    @elseif ($options['currentMenuElement'] == 2)
                        <button class="btn btn-primary btn-sm"
                            wire:click="action_show_form('company_departements', true, true)">{{ __('New departement') }}</button>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="row m-0{{ $options['currentMenuElement'] == 0 ? '' : ' hidden' }}">
                    @include('livewire.companies.includes.tabs.general')
                </div>

                <div class="row m-0{{ $options['currentMenuElement'] == 1 ? '' : ' hidden' }}">
                    @include('livewire.companies.includes.tabs.sites')
                </div>

                <div class="row m-0{{ $options['currentMenuElement'] == 2 ? '' : ' hidden' }}">
                    @include('livewire.companies.includes.tabs.departements')
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.includes.base.form-buttons')
