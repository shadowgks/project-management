@php
    use App\Helpers\TemplateHelper;
    $time = time();
    $baseDataLength = count($base_data);
    $filterLoopsLength = count($filterLoops);
@endphp

<div id="live-component">
    {{-- cards --}}
    @include('livewire.includes.base.cards')

    <div class="card">
        <div class="card-header border-0">
            <div class="card-title">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ $options['module_name'] }}</h1>
            </div>
            <div class="card-toolbar">
                @if ($base_data['permissions']['create'])
                    <a class="btn btn-sm btn-primary font-weight-bolder font-size-sm cursor-pointer me-1"
                        onclick="loadingVisibility(true)" wire:click="action_options('show_modal')">
                        {{ __('Add') . ($base_data['buttons']['add'] ?? '') }}
                    </a>
                @endif
                @if (count($base_data['custom_filters']) > 0 || $filterLoopsLength > 0)
                    <a class="btn btn-sm btn-primary btn-icon font-weight-bolder font-size-sm cursor-pointer"
                        onclick="loadingVisibility(true)" wire:click="action_options('show_filters')">
                        <i class="fa fa-sliders p-0"></i>
                    </a>
                @endif
            </div>
        </div>

        {{-- filters --}}
        @include('livewire.includes.base.filters')
    </div>

    <!-- NOTE - Table -->
    <livewire:table _id="{{ $base_data['module_name'] }}" :columns="$base_data['columns']" :filters="$filters" :module_id="$options['module_id'] ?? null"
        route="{{ route($base_data['module_name'] . '.list') }}" />

    {{-- Form include - start --}}
    @include('livewire.includes.base.form-demo1')
    {{-- Form include - end --}}
</div>
