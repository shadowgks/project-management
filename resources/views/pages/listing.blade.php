<x-base-layout>
    <x-card :hastitle="true"  :hasfooter="false"  bodyclass="" >
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
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Add Customer</button>

                    <!--end::Add customer-->
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
         
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px">User</th>
                    <th class="min-w-125px">Role</th>
                    <th class="min-w-125px">Last login</th>
                    <th class="min-w-125px">Two-step</th>
                    <th class="min-w-125px">Progress</th>
                    <th class="text-end min-w-100px">Actions</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="text-gray-600 fw-semibold">
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label">
                                    <img src="{{ asset(theme()->getDemo() . '/media/avatars/300-6.jpg' ) }}" alt="Emma Smith" class="w-100" />
                                </div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                            <span>smith@kpmg.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Administrator</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">Yesterday</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    <td><x-badge type="light-warning" message="Disabled" /></td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="34% completed">
                            <div class="bg-warning rounded h-5px" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="lar la-edit"></i></a>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
                            <span>melody@altbox.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Analyst</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">20 mins ago</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    <td><x-badge type="light-success" message="Enabled" /></td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="22% completed">
                            <div class="bg-danger rounded h-5px" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="lar la-edit"></i></a>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label">
                                    <img src="{{ asset(theme()->getDemo() . '/media/avatars/300-1.jpg' ) }}" alt="Max Smith" class="w-100" />
                                </div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Max Smith</a>
                            <span>max@kt.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Developer</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">3 days ago</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    
                    <td><x-badge type="light-warning" message="Disabled" /></td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="100% completed">
                            <div class="bg-success rounded h-5px" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="las la-edit"></i>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label">
                                    <img src="{{ asset(theme()->getDemo() . '/media/avatars/300-5.jpg' ) }}" alt="Sean Bean" class="w-100" />
                                </div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Sean Bean</a>
                            <span>sean@dellito.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Support</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">5 hours ago</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    <td><x-badge type="light-success" message="Enabled" />
                    </td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="67% completed">
                            <div class="bg-info rounded h-5px" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="lar la-edit"></i></a>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label">
                                    <img src="{{ asset(theme()->getDemo() . '/media/avatars/300-25.jpg' ) }}" alt="Brian Cox" class="w-100" />
                                </div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Brian Cox</a>
                            <span>brian@exchange.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Developer</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">2 days ago</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    <td><x-badge type="light-success" message="Enabled" /></td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="55% completed">
                            <div class="bg-primary rounded h-5px" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="lar la-edit"></i></a>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <!--begin::User=-->
                    <td class="d-flex align-items-center">
                        <!--begin:: Avatar -->
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label fs-3 bg-light-warning text-warning">C</div>
                            </a>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User details-->
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">Mikaela Collins</a>
                            <span>mik@pex.com</span>
                        </div>
                        <!--begin::User details-->
                    </td>
                    <!--end::User=-->
                    <!--begin::Role=-->
                    <td>Administrator</td>
                    <!--end::Role=-->
                    <!--begin::Last login=-->
                    <td>
                        <div class="badge badge-light fw-bold">5 days ago</div>
                    </td>
                    <!--end::Last login=-->
                    <!--begin::Two step=-->
                    <td><x-badge type="light-warning" message="Disabled" /></td>
                    <!--end::Two step=-->
                    <!--begin::Joined-->
                    
                    <td>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="50% completed">
                            <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <!--begin::Joined-->
                    <!--begin::Action=-->
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="lar la-edit"></i></a>
                        
                        <a href="#" class="btn btn-danger btn-active-light-primary btn-sm p-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="las la-trash"></i></a>
                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
            </tbody>
            <!--end::Table body-->
        </table>
    </x-card>

    <x-modal title="Add a Customer" id="kt_modal_add_customer" />
    <x-modal title="Export Users" id="kt_customers_export_modal" />
</x-base-layout>
