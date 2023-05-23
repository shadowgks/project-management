@if ($base_data['permissions']['view_file_upload'] &&
    count($base_data['app_module']) > 0 &&
    $base_data['app_module']['activate_file_upload'])
    <div class="tab-pane fade" id="kt_upload_file_view" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped dataTable gy-5 gx-2">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        @foreach ($base_data['content']['files']['columns'] as $column)
                            <th class="sorting">
                                {{ $column }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                            fill="currentColor"></path>
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <a href="#" class="text-gray-800 text-hover-primary">api-keys.html</a>
                            </div>
                        </td>
                        <td>489 KB</td>
                        <td>
                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox">
                                <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                        </td>
                        <td data-order="2022-09-22T20:43:00+01:00">
                            22 Sep 2022, 8:43 pm
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                                    <i class="fa fa-download p-0"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                            fill="currentColor"></path>
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <a href="#" class="text-gray-800 text-hover-primary">api-values.xml</a>
                            </div>
                        </td>
                        <td>540 KB</td>
                        <td>
                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox">
                                <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                        </td>
                        <td data-order="2022-09-22T20:43:00+01:00">
                            21 Sep 2022, 10:43 pm
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                                    <i class="fa fa-download p-0"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
