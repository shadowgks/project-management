<x-base-layout>
    <div class="row">
        <div class="row">
            <div class="row">
                <div class="col-md-6"> 
                    <x-card :hastitle="true"  :hasfooter="false" bodyclass="">
                        <x-slot name="headerContent">
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <!--begin::Filter-->
                                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Filter</button>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-4 text-dark fw-bold">Filter Options</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Separator-->
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                                    <option></option>
                                                    <option value="aug">August</option>
                                                    <option value="sep">September</option>
                                                    <option value="oct">October</option>
                                                    <option value="nov">November</option>
                                                    <option value="dec">December</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="payment_type">
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" />
                                                        <span class="form-check-label text-gray-600">All</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                                        <span class="form-check-label text-gray-600">Visa</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio" name="payment_type" value="mastercard" />
                                                        <span class="form-check-label text-gray-600">Mastercard</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" name="payment_type" value="american_express" />
                                                        <span class="form-check-label text-gray-600">American Express</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                                <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Menu 1-->
                                    <!--end::Filter-->
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                            <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                                            <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Export</button>
                                    <!--end::Export-->
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                                    <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                        </x-slot>
                        <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_4_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Order ID</th>
                                    <th class="text-end min-w-125px">Customer</th>
                                    <th class="text-end min-w-100px">Total</th>
                                    <th class="text-end min-w-100px">Profit</th>
                                    <th class="text-end min-w-50px">Status</th>
                                    <th class="text-end">*</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                                <tr data-kt-table-widget-4="subtable_template" class="d-none">
                                    <td colspan="1">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="#" class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                                                <img src="" data-kt-src-path="assets/media/stock/ecommerce/" alt="" data-kt-table-widget-4="template_image" />
                                            </a>
                                            <div class="d-flex flex-column text-muted">
                                                <a href="#" class="text-gray-800 text-hover-primary fw-bold" data-kt-table-widget-4="template_name">Product name</a>
                                                <div class="fs-7" data-kt-table-widget-4="template_description">Product description</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-gray-800 fs-7">Cost</div>
                                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">1</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-gray-800 fs-7">Qty</div>
                                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_qty">1</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-gray-800 fs-7">Total</div>
                                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_total">name</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-gray-800 fs-7 me-3">On hand</div>
                                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_stock">32</div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#XGY-346</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Albert Flores</a>
                                    </td>
                                    <td class="text-end">$630.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$86.70</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#YHD-047</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Jenny Wilson</a>
                                    </td>
                                    <td class="text-end">$25.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$4.20</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-primary">Confirmed</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#SRR-678</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Robert Fox</a>
                                    </td>
                                    <td class="text-end">$1,630.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$203.90</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#PXF-534</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Cody Fisher</a>
                                    </td>
                                    <td class="text-end">$119.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$12.00</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#XGD-249</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Arlene McCoy</a>
                                    </td>
                                    <td class="text-end">$660.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$52.26</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#SKP-035</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Eleanor Pena</a>
                                    </td>
                                    <td class="text-end">$290.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$29.00</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-danger">Rejected</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary">#SKP-567</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">Dan Wilson</a>
                                    </td>
                                    <td class="text-end">$590.00</td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bolder">$50.00</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-off">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                                            <span class="svg-icon svg-icon-3 m-0 toggle-on">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </x-card>
                </div>
                <div class="col-md-6"> 
                    <x-card :hastitle="false"  :hasfooter="false" bodyclass="" >
                        
                        <div class="d-flex flex-column ">
                            <!--begin::Content-->
                            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                                <!--begin::Invoice 2 content-->
                                <div class="mt-n1">
                                    <!--begin::Top-->
                                    <div class="d-flex flex-stack pb-10">
                                        <!--begin::Logo-->
                                        <a href="#">
                                            <img alt="Logo" src="{{ asset(theme()->getDemo() . '/media/svg/brand-logos/code-lab.svg' ) }}" />
                                        </a>
                                        <!--end::Logo-->
                                        <!--begin::Action-->
                                        <a href="#" class="btn btn-sm btn-success">Pay Now</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Top-->
                                    <!--begin::Wrapper-->
                                    <div class="m-0">
                                        <!--begin::Label-->
                                        <div class="fw-bold fs-3 text-gray-800 mb-8">Invoice #34782</div>
                                        <!--end::Label-->
                                        <!--begin::Row-->
                                        <div class="row g-5 mb-11">
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue Date:</div>
                                                <!--end::Label-->
                                                <!--end::Col-->
                                                <div class="fw-bold fs-6 text-gray-800">12 Apr 2021</div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Col-->
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Due Date:</div>
                                                <!--end::Label-->
                                                <!--end::Info-->
                                                <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                    <span class="pe-2">02 May 2021</span>
                                                    <span class="fs-7 text-danger d-flex align-items-center">
                                                    <span class="bullet bullet-dot bg-danger me-2"></span>Due in 7 days</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row g-5 mb-12">
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue For:</div>
                                                <!--end::Label-->
                                                <!--end::Text-->
                                                <div class="fw-bold fs-6 text-gray-800">KeenThemes Inc.</div>
                                                <!--end::Text-->
                                                <!--end::Description-->
                                                <div class="fw-semibold fs-7 text-gray-600">8692 Wild Rose Drive
                                                <br />Livonia, MI 48150</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Col-->
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issued By:</div>
                                                <!--end::Label-->
                                                <!--end::Text-->
                                                <div class="fw-bold fs-6 text-gray-800">CodeLab Inc.</div>
                                                <!--end::Text-->
                                                <!--end::Description-->
                                                <div class="fw-semibold fs-7 text-gray-600">9858 South 53rd Ave.
                                                <br />Matthews, NC 28104</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Content-->
                                        <div class="flex-grow-1">
                                            <!--begin::Table-->
                                            <div class="table-responsive border-bottom mb-9">
                                                <table class="table mb-3">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                                            <th class="min-w-175px pb-2">Description</th>
                                                            <th class="min-w-70px text-end pb-2">Hours</th>
                                                            <th class="min-w-80px text-end pb-2">Rate</th>
                                                            <th class="min-w-100px text-end pb-2">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                            <td class="d-flex align-items-center pt-6">
                                                            <i class="fa fa-genderless text-danger fs-2 me-2"></i>Creative Design</td>
                                                            <td class="pt-6">80</td>
                                                            <td class="pt-6">$40.00</td>
                                                            <td class="pt-6 text-dark fw-bolder">$3200.00</td>
                                                        </tr>
                                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                            <td class="d-flex align-items-center">
                                                            <i class="fa fa-genderless text-success fs-2 me-2"></i>Logo Design</td>
                                                            <td>120</td>
                                                            <td>$40.00</td>
                                                            <td class="fs-5 text-dark fw-bolder">$4800.00</td>
                                                        </tr>
                                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                            <td class="d-flex align-items-center">
                                                            <i class="fa fa-genderless text-primary fs-2 me-2"></i>Web Development</td>
                                                            <td>210</td>
                                                            <td>$60.00</td>
                                                            <td class="fs-5 text-dark fw-bolder">$12600.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                            <!--begin::Container-->
                                            <div class="d-flex justify-content-end">
                                                <!--begin::Section-->
                                                <div class="mw-300px">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountname-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                                        <!--end::Accountname-->
                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">$ 20,600.00</div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountname-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">VAT 0%</div>
                                                        <!--end::Accountname-->
                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">0.00</div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountnumber-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal + VAT</div>
                                                        <!--end::Accountnumber-->
                                                        <!--begin::Number-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">$ 20,600.00</div>
                                                        <!--end::Number-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Code-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Total</div>
                                                        <!--end::Code-->
                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">$ 20,600.00</div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Container-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Invoice 2 content-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Sidebar-->
                            <div class="m-0">
                                <!--begin::Invoice 2 sidebar-->
                                <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                                    <!--begin::Labels-->
                                    <div class="mb-8">
                                        <x-badge type="light-success me-2" message="Approved" />
                                        <x-badge type="light-warning" message="Pending Payment" />
                                    </div>
                                    <!--end::Labels-->
                                    <!--begin::Title-->
                                    <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PAYMENT DETAILS</h6>
                                    <!--end::Title-->
                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Paypal:</div>
                                        <div class="fw-bold text-gray-800 fs-6">codelabpay@codelab.co</div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Account:</div>
                                        <div class="fw-bold text-gray-800 fs-6">Nl24IBAN34553477847370033
                                        <br />AMB NLANBZTC</div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="mb-15">
                                        <div class="fw-semibold text-gray-600 fs-7">Payment Term:</div>
                                        <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">14 days
                                        <span class="fs-7 text-danger d-flex align-items-center">
                                        <span class="bullet bullet-dot bg-danger mx-2"></span>Due in 7 days</span></div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Title-->
                                    <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PROJECT OVERVIEW</h6>
                                    <!--end::Title-->
                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Project Name</div>
                                        <div class="fw-bold fs-6 text-gray-800">SaaS App Quickstarter
                                        <a href="#" class="link-primary ps-1">View Project</a></div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Completed By:</div>
                                        <div class="fw-bold text-gray-800 fs-6">Mr. Dewonte Paul</div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="m-0">
                                        <div class="fw-semibold text-gray-600 fs-7">Time Spent:</div>
                                        <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">230 Hours
                                        <span class="fs-7 text-success d-flex align-items-center">
                                        <span class="bullet bullet-dot bg-success mx-2"></span>35$/h Rate</span></div>
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Invoice 2 sidebar-->
                            </div>
                            <!--end::Sidebar-->
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>