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
                    {{-- @foreach ($formElements as $element)
                        @if ($element['menu'] == $options['currentMenuElement'])
                            {!! TemplateHelper::getFormElement($element) !!}
                        @endif
                    @endforeach --}}
                    {{-- form - end --}}
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.includes.base.form-buttons')
