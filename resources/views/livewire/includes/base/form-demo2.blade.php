@php
    use App\Helpers\TemplateHelper;
@endphp

<div class="card card-sticky mt-6 {!! $options['show_form'] ? '' : 'hidden' !!}">
    <div class="card-header">
        <h3 class="card-title">{{ $options['title_content'] }}</h3>
        {{-- <div class="card-toolbar">
            <button type="button" class="btn btn-danger btn-sm btn-shadow me-1" onclick="loadingVisibility(true)"
                wire:click="cancel('show_form')">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-success btn-sm btn-shadow" onclick="loadingVisibility(true)"
                wire:click="save">{{ __('Save') }}</button>
        </div> --}}
    </div>

    <div class="card-body">
        <div class="row m-0">
            {{-- form - start --}}
            @foreach ($formElements as $element)
                {!! TemplateHelper::getFormElement($element) !!}
            @endforeach
            {{-- form - end --}}
        </div>
    </div>
</div>

@include('livewire.includes.base.form-buttons')
