@php
    use App\Helpers\TemplateHelper;
@endphp

<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Login Sessions</h3>
        </div>

        {{-- <div class="card-toolbar">
            <div class="my-1 me-4">
                <select class="form-select form-select-sm form-select-solid w-125px select2-hidden-accessible"
                    data-control="select2" data-placeholder="Select Hours" data-hide-search="true"
                    data-select2-id="select2-data-10-rvso" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                    <option value="1" selected="" data-select2-id="select2-data-12-m07p">1 Hours</option>
                    <option value="2">6 Hours</option>
                    <option value="3">12 Hours</option>
                    <option value="4">24 Hours</option>
                </select>
                <span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                    data-select2-id="select2-data-11-zl1h" style="width: 100%;"><span class="selection"><span
                            class="select2-selection select2-selection--single form-select form-select-sm form-select-solid w-125px"
                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                            aria-disabled="false" aria-labelledby="select2-pw7c-container"
                            aria-controls="select2-pw7c-container"><span class="select2-selection__rendered"
                                id="select2-pw7c-container" role="textbox" aria-readonly="true" title="1 Hours">1
                                Hours</span><span class="select2-selection__arrow" role="presentation"><b
                                    role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                        aria-hidden="true"></span></span>
            </div>

            <a href="#" class="btn btn-sm btn-primary my-1">
                View All
            </a>
        </div> --}}
    </div>

    {{-- <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                    <tr>
                        <th class="min-w-250px">Device</th>
                        <th class="min-w-100px">Action</th>
                        <th class="min-w-150px">Browser</th>
                        <th class="min-w-150px">IP Address</th>
                        <th class="min-w-150px">Time</th>
                    </tr>
                </thead>

                <tbody class="fw-6 fw-semibold text-gray-600">
                    <tr>
                        <td>
                            <a href="#" class="text-hover-primary text-gray-600">USA(5)</a>
                        </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-bold">OK</span>
                        </td>

                        <td>Chrome - Windows</td>

                        <td>236.125.56.78</td>

                        <td>2 mins ago</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="text-hover-primary text-gray-600">United Kingdom(10)</a>
                        </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-bold">OK</span>
                        </td>

                        <td>Safari - Mac OS</td>

                        <td>236.125.56.78</td>

                        <td>10 mins ago</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="text-hover-primary text-gray-600">Norway(-)</a>
                        </td>

                        <td>
                            <span class="badge badge-light-danger fs-7 fw-bold">ERR</span>
                        </td>

                        <td>Firefox - Windows</td>

                        <td>236.125.56.10</td>

                        <td>20 mins ago</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="text-hover-primary text-gray-600">Japan(112)</a>
                        </td>

                        <td>
                            <span class="badge badge-light-success fs-7 fw-bold">OK</span>
                        </td>

                        <td>iOS - iPhone Pro</td>

                        <td>236.125.56.54</td>

                        <td>30 mins ago</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="text-hover-primary text-gray-600">Italy(5)</a>
                        </td>

                        <td>
                            <span class="badge badge-light-warning fs-7 fw-bold">WRN</span>
                        </td>

                        <td>Samsung Noted 5- Android</td>

                        <td>236.100.56.50</td>

                        <td>40 mins ago</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div> --}}
    <livewire:table _id="{{ $base_data['datatable'][$tab]['name'] }}" :columns="$base_data['datatable'][$tab]['columns']"
        route="{{ route($base_data['datatable'][$tab]['route']) }}" />
</div>

<div class="card pt-4 ">
    <div class="card-header border-0">
        <div class="card-title">
            <h2>{{ __('Logs') }}</h2>
        </div>

        {{-- <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light-primary">
                <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3"
                            d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z"
                            fill="currentColor"></path>
                        <path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z" fill="currentColor">
                        </path>
                        <path opacity="0.3" d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                {{ __('Download Report') }}
            </button>
        </div> --}}
    </div>

    <div class="card-body py-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                id="kt_table_customers_logs">
                <tbody>
                    @foreach ($base_data['logs'] as $log)
                        <tr>
                            <td class="min-w-70px">
                                <div class="badge badge-light-{{ TemplateHelper::getEventColor($log['event']) }}">
                                    {{ $log['event'] }}</div>
                            </td>

                            <td>{{ $log['description'] }}</td>

                            <td class="pe-0 text-end min-w-200px">
                                {{ _dt($log['created_at']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
