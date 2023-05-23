@php
    use Carbon\Carbon;
    $data_length = count($base_data['data']);
@endphp
@inject('string_helper', 'App\Helpers\StringHelper')
@section('title', 'Generate filters')

<div class="container-fluid" id="live-component" style="overflow:{{ $this->options['modal_opened'] ? ' hidden' : '' }};">
    <div class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <!-- NOTE - App toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Generate filters
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="/" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Generate filters</li>
                        </ul>
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a class="btn btn-sm fw-bold btn-primary" wire:click="action_modal('show', 'show_steps_modal')">
                            <span>{{ $options['list_en_going'] ? 'Continue editing' : 'Add List' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- NOTE - App body -->
            <div class="app-content flex-column-fluid"s>
                <div class="app-container container-fluid">
                    <!-- NOTE - Settings -->
                    <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
                        route="{{ route($base_data['datatable']['route']) }}" />

                    <!-- NOTE - Preview -->
                    @if ($data_length > 0)
                        <div class="row g-5 g-xl-10 my-5 mb-xl-10">
                            <div class="card card-flush h-xl-100">
                                <div class="card-header pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-dark">Preview</span>
                                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Data with filters</span>
                                    </h3>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="table-responsive">
                                            <table
                                                class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                                id="report-table">
                                                <thead>
                                                    <tr
                                                        class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        @foreach ($base_data['selected_columns'] as $column)
                                                            <th class="sorting">
                                                                {{ $column }}
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($base_data['data'] as $row)
                                                        <tr>
                                                            @foreach ($base_data['selected_columns'] as $column)
                                                                <td>{{ $string_helper::printData($column, $row) }}
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
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('livewire.modals.save-generate-filter')
    @include('livewire.modals.steps-generate-filter')
</div>

@section('scripts')
    <script>
        // NOTE - Events
        // document.addEventListener('filterSaved', function(e) {
        //     let data = e.detail;
        // });
    </script>
@endsection
