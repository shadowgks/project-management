@inject('string_helper', 'App\Helpers\StringHelper')
@section('title', 'Generate dropdowns')

<div class="container-fluid" id="live-component">
    <div class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <!-- NOTE - App toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            {{ __('Generate dropdowns') }}
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="/" class="text-muted text-hover-primary">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">{{ __('Generate dropdowns') }}</li>
                        </ul>
                    </div>

                    @if (!$appOptions['visible'])
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <a class="btn btn-sm fw-bold btn-primary" wire:click="changeVisibility(true)">
                                <span>{{ __('Add Dropdown') }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- NOTE - App body -->
            <div class="app-content flex-column-fluid" style="{{ $appOptions['visible'] ? 'display: none;' : '' }}">
                <div class="app-container container-fluid">
                    <!-- NOTE - Settings -->
                    <livewire:table _id="{{ $dropdown_trait['base_data']['datatable']['name'] }}" :columns="$dropdown_trait['base_data']['datatable']['columns']"
                        route="{{ route($dropdown_trait['base_data']['datatable']['route']) }}" />
                </div>
            </div>

            @if ($appOptions['visible'])
                @include('livewire.includes.forms.form-generate-dropdowns')
            @endif
        </div>
    </div>
</div>

@section('scripts')
    <script>
        // NOTE - Events
        // document.addEventListener('filterSaved', function(e) {
        //     let data = e.detail;
        // });
    </script>
@endsection
