@php
    use Carbon\Carbon;
    use App\Helpers\StringHelper;
    $time = time();
@endphp

@section('title', 'Generate reports')

<div class="container-fluid" id="live-component"
    style="overflow:{{ $this->listing['options']['modal_opened'] ? ' hidden' : '' }};">
    <div class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <!-- NOTE - App toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        {{-- <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Generate reports
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="/" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Generate reports</li>
                        </ul> --}}
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a class="btn btn-sm fw-bold btn-primary" wire:click="action_modal('show', 'show_steps_modal')">
                            <span>{{ $listing['options']['list_en_going'] ? 'Continue editing' : 'Add List' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- NOTE - App body -->
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <!-- NOTE - Settings -->
                    <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
                        route="{{ route($base_data['datatable']['route']) }}" />

                    <!-- NOTE - Preview -->
                    @if (count($listing['base_data']['data']) > 0)
                        <div class="row g-5 g-xl-10 my-5 mb-xl-10">
                            <div class="card card-flush h-xl-100">
                                <div class="card-header pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-dark">{{ __('Preview') }}</span>
                                        <span
                                            class="text-gray-400 mt-1 fw-semibold fs-6">{{ $listing['values']['name_table'] }}</span>
                                    </h3>
                                    <div class="card-toolbar">
                                        <button class="btn btn-danger btn-icon btn-sm btn-shadow"
                                            wire:click="listing_clear_preview">
                                            <i class="fa fa-xmark p-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable gy-5 gx-2">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    @foreach ($listing['base_data']['columns_show'] as $column)
                                                        <th
                                                            class="sorting {{ in_array($column, ['action', 'actions', 'option', 'options']) ? 'text-end' : '' }}">
                                                            @if ($column == 'checkbox')
                                                                {{-- <label class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox">
                                                                </label> --}}
                                                            @else
                                                                {{ $column }}
                                                            @endif
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listing['base_data']['data'] as $dt)
                                                    <tr>
                                                        @foreach ($listing['base_data']['columns_show'] as $column)
                                                            {{-- <td>{{ $dt[$column] }} --}}
                                                            <td>{{ StringHelper::printData($column, $dt) }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('livewire.modals.save-generate-report')
    @include('livewire.modals.steps-generate-report')
</div>

@section('scripts')
    <script>
        document.addEventListener('fileGenerated', function(e) {
            alert('File generated');
        });
    </script>
@endsection
