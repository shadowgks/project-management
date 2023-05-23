@if ($base_data['permissions']['view_reminders'] &&
    count($base_data['app_module']) > 0 &&
    $base_data['app_module']['activate_reminders'])
    <div class="tab-pane fade" id="kt_reminder_view" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped dataTable gy-5 gx-2">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        @foreach ($base_data['content']['reminder']['columns'] as $column)
                            <th class="sorting">
                                {{ $column }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($base_data['content']['reminder']['data'] as $key => $dt) --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a
                                        href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-6.jpg"
                                                alt="Emma Smith" class="w-100">
                                        </div>
                                    </a>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                                        class="text-gray-800 text-hover-primary mb-1">Emma
                                        Smith</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a
                                        href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-1.jpg"
                                                alt="Emma Smith" class="w-100">
                                        </div>
                                    </a>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                                        class="text-gray-800 text-hover-primary mb-1">Emma
                                        Smith</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            Administrator
                        </td>
                        <td>
                            2022-12-28
                        </td>
                        <td>
                            2022-12-28
                        </td>
                        <td>
                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox">
                                <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                        </td>
                        <td class="d-flex flex-row">
                            <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                                <i class="fa fa-pencil p-0"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                                <i class="fa fa-trash p-0"></i>
                            </button>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endif
