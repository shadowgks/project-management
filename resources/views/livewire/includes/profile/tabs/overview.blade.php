<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ __('Profile Details') }}</h3>
        </div>

        <a href="/metronic8/demo1/../demo1/account/settings.html"
            class="btn btn-sm btn-primary align-self-center">{{ __('Edit Profile') }}</a>
    </div>

    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Full Name') }}</label>

            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $profile_trait['base_data']['user_name'] }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Company</label>

            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">Keenthemes</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">
                Contact Phone
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                    aria-label="Phone number must be active" data-bs-original-title="Phone number must be active"
                    data-kt-initialized="1"></i>
            </label>

            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">044 3276 454 935</span>

                <span class="badge badge-success">Verified</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Company Site</label>

            <div class="col-lg-8">
                <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">keenthemes.com</a>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">
                Country
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                    aria-label="Country of origination" data-bs-original-title="Country of origination"
                    data-kt-initialized="1"></i>
            </label>

            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Germany</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Communication</label>

            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Email, Phone</span>
            </div>
        </div>

        <div class="row mb-10">
            <label class="col-lg-4 fw-semibold text-muted">Allow Changes</label>

            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800">Yes</span>
            </div>
        </div>


        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">
            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4"><svg width="24" height="24"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                        fill="currentColor"></rect>
                    <rect x="11" y="14" width="7" height="2" rx="1"
                        transform="rotate(-90 11 14)" fill="currentColor"></rect>
                    <rect x="11" y="17" width="2" height="2" rx="1"
                        transform="rotate(-90 11 17)" fill="currentColor"></rect>
                </svg>
            </span>

            <div class="d-flex flex-stack flex-grow-1 ">
                <div class=" fw-semibold">
                    <h4 class="text-gray-900 fw-bold">We need your attention!</h4>

                    <div class="fs-6 text-gray-700 ">Your payment was declined. To start using tools, please <a
                            class="fw-bold" href="/metronic8/demo1/../demo1/account/billing.html">Add Payment
                            Method</a>.</div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row gy-5 g-xl-10">
    <div class="col-xl-8 mb-xl-10">
        <div class="card card-flush h-lg-100">
            <div class="card-header flex-nowrap pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Top Selling Categories</span>

                    <span class="text-gray-400 pt-2 fw-semibold fs-6">8k social visitors</span>
                </h3>

                <div class="card-toolbar">
                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                    rx="4" fill="currentColor"></rect>
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3"
                                    fill="currentColor"></rect>
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3"
                                    fill="currentColor"></rect>
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3"
                                    fill="currentColor"></rect>
                            </svg>
                        </span>
                    </button>


                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
                        </div>

                        <div class="separator mb-3 opacity-75"></div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">
                                New Ticket
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">
                                New Customer
                            </a>
                        </div>

                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                            data-kt-menu-placement="right-start">
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">New Group</span>
                                <span class="menu-arrow"></span>
                            </a>

                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Admin Group
                                    </a>
                                </div>

                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Staff Group
                                    </a>
                                </div>

                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Member Group
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">
                                New Contact
                            </a>
                        </div>

                        <div class="separator mt-3 opacity-75"></div>

                        <div class="menu-item px-3">
                            <div class="menu-content px-3 py-3">
                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                    Generate Reports
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body pt-5 ps-6">
                <div id="kt_charts_widget_5" class="min-h-auto" style="min-height: 365px;">
                    <div id="apexchartsn0asow71" class="apexcharts-canvas apexchartsn0asow71 apexcharts-theme-light"
                        style="width: 780px; height: 350px;"><svg id="SvgjsSvg1105" width="780" height="350"
                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                            class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                            style="background: transparent;">
                            <g id="SvgjsG1107" class="apexcharts-inner apexcharts-graphical"
                                transform="translate(106.48333740234375, 30)">
                                <defs id="SvgjsDefs1106">
                                    <linearGradient id="SvgjsLinearGradient1111" x1="0" y1="0"
                                        x2="0" y2="1">
                                        <stop id="SvgjsStop1112" stop-opacity="0.4"
                                            stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                        <stop id="SvgjsStop1113" stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                        <stop id="SvgjsStop1114" stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                    </linearGradient>
                                    <clipPath id="gridRectMaskn0asow71">
                                        <rect id="SvgjsRect1116" width="653.8333292007446" height="276.685"
                                            x="-2" y="0" rx="0" ry="0"
                                            opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                            fill="#fff"></rect>
                                    </clipPath>
                                    <clipPath id="forecastMaskn0asow71"></clipPath>
                                    <clipPath id="nonForecastMaskn0asow71"></clipPath>
                                    <clipPath id="gridRectMarkerMaskn0asow71">
                                        <rect id="SvgjsRect1117" width="653.8333292007446" height="280.685"
                                            x="-2" y="-2" rx="0" ry="0"
                                            opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                            fill="#fff"></rect>
                                    </clipPath>
                                </defs>
                                <rect id="SvgjsRect1115" width="0" height="276.685" x="0"
                                    y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                    stroke-dasharray="3" fill="url(#SvgjsLinearGradient1111)"
                                    class="apexcharts-xcrosshairs" y2="276.685" filter="none" fill-opacity="0.9">
                                </rect>
                                <g id="SvgjsG1153" class="apexcharts-yaxis apexcharts-xaxis-inversed" rel="0">
                                    <g id="SvgjsG1154"
                                        class="apexcharts-yaxis-texts-g apexcharts-xaxis-inversed-texts-g"
                                        transform="translate(-81.76666259765625, 0)"><text id="SvgjsText1156"
                                            font-family="Helvetica, Arial, sans-serif" x="-15"
                                            y="23.559870129870134" text-anchor="start" dominant-baseline="auto"
                                            font-size="14px" font-weight="600" fill="#3f4254"
                                            class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1157">Phones</tspan>
                                            <title>Phones</title>
                                        </text><text id="SvgjsText1159" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="63.08629870129871" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1160">Laptops</tspan>
                                            <title>Laptops</title>
                                        </text><text id="SvgjsText1162" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="102.61272727272728" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1163">Headsets</tspan>
                                            <title>Headsets</title>
                                        </text><text id="SvgjsText1165" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="142.13915584415585" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1166">Games</tspan>
                                            <title>Games</title>
                                        </text><text id="SvgjsText1168" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="181.66558441558442" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1169">Keyboardsy</tspan>
                                            <title>Keyboardsy</title>
                                        </text><text id="SvgjsText1171" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="221.192012987013" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1172">Monitors</tspan>
                                            <title>Monitors</title>
                                        </text><text id="SvgjsText1174" font-family="Helvetica, Arial, sans-serif"
                                            x="-15" y="260.71844155844155" text-anchor="start"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#3f4254" class="apexcharts-text apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1175">Speakers</tspan>
                                            <title>Speakers</title>
                                        </text></g>
                                </g>
                                <g id="SvgjsG1136" class="apexcharts-xaxis apexcharts-yaxis-inversed">
                                    <g id="SvgjsG1137" class="apexcharts-xaxis-texts-g"
                                        transform="translate(0, -9.333333333333334)"><text id="SvgjsText1138"
                                            font-family="Helvetica, Arial, sans-serif" x="649.8333292007446"
                                            y="306.685" text-anchor="middle" dominant-baseline="auto"
                                            font-size="14px" font-weight="600" fill="#b5b5c3"
                                            class="apexcharts-text apexcharts-xaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1140">16K</tspan>
                                            <title>16K</title>
                                        </text><text id="SvgjsText1141" font-family="Helvetica, Arial, sans-serif"
                                            x="487.27499690055845" y="306.685" text-anchor="middle"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1143">12K</tspan>
                                            <title>12K</title>
                                        </text><text id="SvgjsText1144" font-family="Helvetica, Arial, sans-serif"
                                            x="324.7166646003724" y="306.685" text-anchor="middle"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1146">8K</tspan>
                                            <title>8K</title>
                                        </text><text id="SvgjsText1147" font-family="Helvetica, Arial, sans-serif"
                                            x="162.1583323001862" y="306.685" text-anchor="middle"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1149">4K</tspan>
                                            <title>4K</title>
                                        </text><text id="SvgjsText1150" font-family="Helvetica, Arial, sans-serif"
                                            x="-0.39999999999997726" y="306.685" text-anchor="middle"
                                            dominant-baseline="auto" font-size="14px" font-weight="600"
                                            fill="#b5b5c3" class="apexcharts-text apexcharts-xaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">
                                            <tspan id="SvgjsTspan1152">0K</tspan>
                                            <title>0K</title>
                                        </text></g>
                                </g>
                                <g id="SvgjsG1176" class="apexcharts-grid">
                                    <g id="SvgjsG1177" class="apexcharts-gridlines-horizontal"></g>
                                    <g id="SvgjsG1178" class="apexcharts-gridlines-vertical">
                                        <line id="SvgjsLine1179" x1="0" y1="0" x2="0"
                                            y2="276.685" stroke="#e1e3ea" stroke-dasharray="4"
                                            stroke-linecap="butt" class="apexcharts-gridline"></line>
                                        <line id="SvgjsLine1181" x1="162.75833230018617" y1="0"
                                            x2="162.75833230018617" y2="276.685" stroke="#e1e3ea"
                                            stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline">
                                        </line>
                                        <line id="SvgjsLine1183" x1="325.51666460037234" y1="0"
                                            x2="325.51666460037234" y2="276.685" stroke="#e1e3ea"
                                            stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline">
                                        </line>
                                        <line id="SvgjsLine1185" x1="488.2749969005585" y1="0"
                                            x2="488.2749969005585" y2="276.685" stroke="#e1e3ea"
                                            stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline">
                                        </line>
                                        <line id="SvgjsLine1187" x1="651.0333292007447" y1="0"
                                            x2="651.0333292007447" y2="276.685" stroke="#e1e3ea"
                                            stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline">
                                        </line>
                                    </g>
                                    <line id="SvgjsLine1180" x1="0" y1="277.685" x2="0"
                                        y2="283.685" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                        class="apexcharts-xaxis-tick"></line>
                                    <line id="SvgjsLine1182" x1="162.75833230018617" y1="277.685"
                                        x2="162.75833230018617" y2="283.685" stroke="#e0e0e0" stroke-dasharray="0"
                                        stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                    <line id="SvgjsLine1184" x1="325.51666460037234" y1="277.685"
                                        x2="325.51666460037234" y2="283.685" stroke="#e0e0e0" stroke-dasharray="0"
                                        stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                    <line id="SvgjsLine1186" x1="488.2749969005585" y1="277.685"
                                        x2="488.2749969005585" y2="283.685" stroke="#e0e0e0" stroke-dasharray="0"
                                        stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                    <line id="SvgjsLine1188" x1="651.0333292007447" y1="277.685"
                                        x2="651.0333292007447" y2="283.685" stroke="#e0e0e0" stroke-dasharray="0"
                                        stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                    <line id="SvgjsLine1190" x1="0" y1="276.685" x2="649.8333292007446"
                                        y2="276.685" stroke="transparent" stroke-dasharray="0"
                                        stroke-linecap="butt"></line>
                                    <line id="SvgjsLine1189" x1="0" y1="1" x2="0"
                                        y2="276.685" stroke="transparent" stroke-dasharray="0"
                                        stroke-linecap="butt"></line>
                                </g>
                                <g id="SvgjsG1118" class="apexcharts-bar-series apexcharts-plot-series">
                                    <g id="SvgjsG1119" class="apexcharts-series" rel="1"
                                        seriesName="series-1" data:realIndex="0">
                                        <path id="SvgjsPath1123"
                                            d="M 0.1 15.217675L 605.3187461256981 15.217675Q 609.3187461256981 15.217675 609.3187461256981 19.217675L 609.3187461256981 20.308753571428575Q 609.3187461256981 24.308753571428575 605.3187461256981 24.308753571428575L 605.3187461256981 24.308753571428575L 0.1 24.308753571428575L 0.1 24.308753571428575z"
                                            fill="rgba(62,151,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 15.217675L 605.3187461256981 15.217675Q 609.3187461256981 15.217675 609.3187461256981 19.217675L 609.3187461256981 20.308753571428575Q 609.3187461256981 24.308753571428575 605.3187461256981 24.308753571428575L 605.3187461256981 24.308753571428575L 0.1 24.308753571428575L 0.1 24.308753571428575z"
                                            pathFrom="M 0.1 15.217675L 0.1 15.217675L 0.1 24.308753571428575L 0.1 24.308753571428575L 0.1 24.308753571428575L 0.1 24.308753571428575L 0.1 24.308753571428575L 0.1 15.217675"
                                            cy="54.744103571428575" cx="609.3187461256981" j="0"
                                            val="15" barHeight="9.091078571428573"
                                            barWidth="609.2187461256981"></path>
                                        <path id="SvgjsPath1125"
                                            d="M 0.1 54.744103571428575L 483.47499690055844 54.744103571428575Q 487.47499690055844 54.744103571428575 487.47499690055844 58.744103571428575L 487.47499690055844 59.83518214285715Q 487.47499690055844 63.83518214285715 483.47499690055844 63.83518214285715L 483.47499690055844 63.83518214285715L 0.1 63.83518214285715L 0.1 63.83518214285715z"
                                            fill="rgba(241,65,108,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 54.744103571428575L 483.47499690055844 54.744103571428575Q 487.47499690055844 54.744103571428575 487.47499690055844 58.744103571428575L 487.47499690055844 59.83518214285715Q 487.47499690055844 63.83518214285715 483.47499690055844 63.83518214285715L 483.47499690055844 63.83518214285715L 0.1 63.83518214285715L 0.1 63.83518214285715z"
                                            pathFrom="M 0.1 54.744103571428575L 0.1 54.744103571428575L 0.1 63.83518214285715L 0.1 63.83518214285715L 0.1 63.83518214285715L 0.1 63.83518214285715L 0.1 63.83518214285715L 0.1 54.744103571428575"
                                            cy="94.27053214285715" cx="487.47499690055844" j="1"
                                            val="12" barHeight="9.091078571428573"
                                            barWidth="487.3749969005584"></path>
                                        <path id="SvgjsPath1127"
                                            d="M 0.1 94.27053214285715L 402.2458307504654 94.27053214285715Q 406.2458307504654 94.27053214285715 406.2458307504654 98.27053214285715L 406.2458307504654 99.36161071428572Q 406.2458307504654 103.36161071428572 402.2458307504654 103.36161071428572L 402.2458307504654 103.36161071428572L 0.1 103.36161071428572L 0.1 103.36161071428572z"
                                            fill="rgba(80,205,137,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 94.27053214285715L 402.2458307504654 94.27053214285715Q 406.2458307504654 94.27053214285715 406.2458307504654 98.27053214285715L 406.2458307504654 99.36161071428572Q 406.2458307504654 103.36161071428572 402.2458307504654 103.36161071428572L 402.2458307504654 103.36161071428572L 0.1 103.36161071428572L 0.1 103.36161071428572z"
                                            pathFrom="M 0.1 94.27053214285715L 0.1 94.27053214285715L 0.1 103.36161071428572L 0.1 103.36161071428572L 0.1 103.36161071428572L 0.1 103.36161071428572L 0.1 103.36161071428572L 0.1 94.27053214285715"
                                            cy="133.79696071428572" cx="406.2458307504654" j="2"
                                            val="10" barHeight="9.091078571428573"
                                            barWidth="406.1458307504654"></path>
                                        <path id="SvgjsPath1129"
                                            d="M 0.1 133.79696071428572L 321.01666460037234 133.79696071428572Q 325.01666460037234 133.79696071428572 325.01666460037234 137.79696071428572L 325.01666460037234 138.88803928571429Q 325.01666460037234 142.88803928571429 321.01666460037234 142.88803928571429L 321.01666460037234 142.88803928571429L 0.1 142.88803928571429L 0.1 142.88803928571429z"
                                            fill="rgba(255,199,0,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 133.79696071428572L 321.01666460037234 133.79696071428572Q 325.01666460037234 133.79696071428572 325.01666460037234 137.79696071428572L 325.01666460037234 138.88803928571429Q 325.01666460037234 142.88803928571429 321.01666460037234 142.88803928571429L 321.01666460037234 142.88803928571429L 0.1 142.88803928571429L 0.1 142.88803928571429z"
                                            pathFrom="M 0.1 133.79696071428572L 0.1 133.79696071428572L 0.1 142.88803928571429L 0.1 142.88803928571429L 0.1 142.88803928571429L 0.1 142.88803928571429L 0.1 142.88803928571429L 0.1 133.79696071428572"
                                            cy="173.32338928571428" cx="325.01666460037234" j="3"
                                            val="8" barHeight="9.091078571428573"
                                            barWidth="324.9166646003723"></path>
                                        <path id="SvgjsPath1131"
                                            d="M 0.1 173.32338928571428L 280.4020815253258 173.32338928571428Q 284.4020815253258 173.32338928571428 284.4020815253258 177.32338928571428L 284.4020815253258 178.41446785714285Q 284.4020815253258 182.41446785714285 280.4020815253258 182.41446785714285L 280.4020815253258 182.41446785714285L 0.1 182.41446785714285L 0.1 182.41446785714285z"
                                            fill="rgba(114,57,234,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 173.32338928571428L 280.4020815253258 173.32338928571428Q 284.4020815253258 173.32338928571428 284.4020815253258 177.32338928571428L 284.4020815253258 178.41446785714285Q 284.4020815253258 182.41446785714285 280.4020815253258 182.41446785714285L 280.4020815253258 182.41446785714285L 0.1 182.41446785714285L 0.1 182.41446785714285z"
                                            pathFrom="M 0.1 173.32338928571428L 0.1 173.32338928571428L 0.1 182.41446785714285L 0.1 182.41446785714285L 0.1 182.41446785714285L 0.1 182.41446785714285L 0.1 182.41446785714285L 0.1 173.32338928571428"
                                            cy="212.84981785714285" cx="284.4020815253258" j="4"
                                            val="7" barHeight="9.091078571428573"
                                            barWidth="284.3020815253258"></path>
                                        <path id="SvgjsPath1133"
                                            d="M 0.1 212.84981785714285L 158.55833230018615 212.84981785714285Q 162.55833230018615 212.84981785714285 162.55833230018615 216.84981785714285L 162.55833230018615 217.94089642857142Q 162.55833230018615 221.94089642857142 158.55833230018615 221.94089642857142L 158.55833230018615 221.94089642857142L 0.1 221.94089642857142L 0.1 221.94089642857142z"
                                            fill="rgba(80,205,205,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 212.84981785714285L 158.55833230018615 212.84981785714285Q 162.55833230018615 212.84981785714285 162.55833230018615 216.84981785714285L 162.55833230018615 217.94089642857142Q 162.55833230018615 221.94089642857142 158.55833230018615 221.94089642857142L 158.55833230018615 221.94089642857142L 0.1 221.94089642857142L 0.1 221.94089642857142z"
                                            pathFrom="M 0.1 212.84981785714285L 0.1 212.84981785714285L 0.1 221.94089642857142L 0.1 221.94089642857142L 0.1 221.94089642857142L 0.1 221.94089642857142L 0.1 221.94089642857142L 0.1 212.84981785714285"
                                            cy="252.37624642857142" cx="162.55833230018615" j="5"
                                            val="4" barHeight="9.091078571428573"
                                            barWidth="162.45833230018616"></path>
                                        <path id="SvgjsPath1135"
                                            d="M 0.1 252.37624642857142L 117.9437492251396 252.37624642857142Q 121.9437492251396 252.37624642857142 121.9437492251396 256.37624642857145L 121.9437492251396 257.467325Q 121.9437492251396 261.467325 117.9437492251396 261.467325L 117.9437492251396 261.467325L 0.1 261.467325L 0.1 261.467325z"
                                            fill="rgba(63,66,84,0.85)" fill-opacity="1" stroke-opacity="1"
                                            stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                            class="apexcharts-bar-area" index="0"
                                            clip-path="url(#gridRectMaskn0asow71)"
                                            pathTo="M 0.1 252.37624642857142L 117.9437492251396 252.37624642857142Q 121.9437492251396 252.37624642857142 121.9437492251396 256.37624642857145L 121.9437492251396 257.467325Q 121.9437492251396 261.467325 117.9437492251396 261.467325L 117.9437492251396 261.467325L 0.1 261.467325L 0.1 261.467325z"
                                            pathFrom="M 0.1 252.37624642857142L 0.1 252.37624642857142L 0.1 261.467325L 0.1 261.467325L 0.1 261.467325L 0.1 261.467325L 0.1 261.467325L 0.1 252.37624642857142"
                                            cy="291.902675" cx="121.9437492251396" j="6" val="3"
                                            barHeight="9.091078571428573" barWidth="121.8437492251396"></path>
                                        <g id="SvgjsG1121" class="apexcharts-bar-goals-markers"
                                            style="pointer-events: none">
                                            <g id="SvgjsG1122" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1124" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1126" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1128" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1130" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1132" className="apexcharts-bar-goals-groups"></g>
                                            <g id="SvgjsG1134" className="apexcharts-bar-goals-groups"></g>
                                        </g>
                                    </g>
                                    <g id="SvgjsG1120" class="apexcharts-datalabels" data:realIndex="0"></g>
                                </g>
                                <line id="SvgjsLine1191" x1="0" y1="0" x2="649.8333292007446"
                                    y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                    stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                <line id="SvgjsLine1192" x1="0" y1="0" x2="649.8333292007446"
                                    y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs-hidden"></line>
                                <g id="SvgjsG1193" class="apexcharts-yaxis-annotations"></g>
                                <g id="SvgjsG1194" class="apexcharts-xaxis-annotations"></g>
                                <g id="SvgjsG1195" class="apexcharts-point-annotations"></g>
                            </g>
                            <g id="SvgjsG1108" class="apexcharts-annotations"></g>
                        </svg>
                        <div class="apexcharts-legend" style="max-height: 175px;"></div>
                        <div class="apexcharts-tooltip apexcharts-theme-light"
                            style="left: 227.483px; top: 237.685px;">
                            <div class="apexcharts-tooltip-title"
                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Speakers</div>
                            <div class="apexcharts-tooltip-series-group apexcharts-active"
                                style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker"
                                    style="background-color: rgba(63, 66, 84, 0.85);"></span>
                                <div class="apexcharts-tooltip-text"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                    <div class="apexcharts-tooltip-y-group"><span
                                            class="apexcharts-tooltip-text-y-label">series-1: </span><span
                                            class="apexcharts-tooltip-text-y-value">3</span></div>
                                    <div class="apexcharts-tooltip-goals-group"><span
                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                            class="apexcharts-tooltip-text-goals-value"></span></div>
                                    <div class="apexcharts-tooltip-z-group"><span
                                            class="apexcharts-tooltip-text-z-label"></span><span
                                            class="apexcharts-tooltip-text-z-value"></span></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                            <div class="apexcharts-yaxistooltip-text"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="col-xl-4 mb-5 mb-xl-10">

        <div class="card h-md-100" dir="ltr">
            <div class="card-body d-flex flex-column flex-center">
                <div class="mb-2">
                    <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                        Have you tried <br> new
                        <span class="fw-bolder"> Mobile Application ?</span>
                    </h1>

                    <div class="py-10 text-center">
                        <img src="/metronic8/demo1/assets/media/svg/illustrations/easy/1.svg"
                            class="theme-light-show w-200px" alt="">
                        <img src="/metronic8/demo1/assets/media/svg/illustrations/easy/1-dark.svg"
                            class="theme-dark-show w-200px" alt="">
                    </div>
                </div>

                <div class="text-center mb-1">
                    <a class="btn btn-sm btn-primary me-2" data-bs-target="#kt_modal_create_app"
                        data-bs-toggle="modal">
                        Try now </a>

                    <a class="btn btn-sm btn-light"
                        href="/metronic8/demo1/../demo1/apps/invoices/view/invoice-1.html">
                        Learn more </a>
                </div>
            </div>
        </div>

    </div>
</div>
