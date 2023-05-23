@php
    use App\Helpers\TemplateHelper;
    $time = time();
    $dueDateDays = TemplateHelper::checkDueDate($data['due-date']);
@endphp

<div wire:key="invoice-template-{{ $time }}">
    <div class="card">
        <div class="card-body p-lg-20">
            <div class="d-flex flex-column flex-xl-row">
                <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                    <div class="mt-n1">
                        <div class="d-flex flex-stack pb-10">
                            <a href="#">
                                <img alt="Logo" src="{{ $data['logo'] }}">
                            </a>
                            @if (isset($data['link']))
                                <a href="{{ $data['link'] }}"
                                    class="btn btn-sm btn-success cursor-pointer">{{ __('Pay Now') }}</a>
                            @endif
                        </div>
                        <div class="m-0">
                            <div class="fw-bold fs-3 text-gray-800 mb-8">{{ __('Invoice') }} #{{ $data['code'] }}</div>
                            <div class="row g-5 mb-11">
                                <div class="col-sm-6">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ __('Date') }}:</div>
                                    <div class="fw-bold fs-6 text-gray-800">
                                        {{ TemplateHelper::getDateFormat($data['date']) }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ __('Due Date') }}:</div>
                                    <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                        <span
                                            class="pe-2">{{ TemplateHelper::getDateFormat($data['due-date']) }}</span>
                                        @if ($dueDateDays['show'])
                                            <span class="fs-7 text-danger d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-danger me-2"></span>
                                                {{ __('Due in') . ' ' . $dueDateDays['days'] . ' ' . __('days') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 mb-12">
                                <div class="col-sm-6">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ __('For') }}:</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $data['for']['name'] ?? '-' }}</div>
                                    <div class="fw-semibold fs-7 text-gray-600">
                                        {{ $data['for']['address'] ?? '-' }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ __('By') }}:</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $data['by']['name'] ?? '-' }}</div>
                                    <div class="fw-semibold fs-7 text-gray-600">
                                        {{ $data['by']['address'] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table mb-3">
                                        <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                                <th class="min-w-175px pb-2">{{ __('Description') }}</th>
                                                <th class="min-w-70px text-end pb-2">{{ __('Hours') }}</th>
                                                <th class="min-w-80px text-end pb-2">{{ __('Rate') }}</th>
                                                <th class="min-w-100px text-end pb-2">{{ __('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['items'] as $item)
                                                <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                    <td class="d-flex align-items-center pt-6">
                                                        @if (isset($item['color']))
                                                            <i
                                                                class="fa fa-genderless text-{{ $item['color'] }} fs-2 me-2"></i>
                                                        @endif
                                                        <span>{{ $item['description'] }}</span>
                                                    </td>
                                                    <td class="pt-6">{{ $item['hours'] }}</td>
                                                    <td class="pt-6">
                                                        {{ TemplateHelper::formatPrice($item['rate']) }}
                                                    </td>
                                                    <td class="pt-6 text-dark fw-bolder">
                                                        {{ TemplateHelper::formatPrice($item['amount']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="mw-300px">
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('Subtotal') }}:
                                            </div>
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ TemplateHelper::formatPrice($data['subtotal']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('VAT') }}
                                                {{ $data['vat-percentage'] ?? 0 }}%
                                            </div>
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ TemplateHelper::formatPrice($data['vat']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('Subtotal') }} +
                                                {{ __('VAT') }}</div>
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ TemplateHelper::formatPrice($data['subtotal-vat']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-stack">
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('Total') }}</div>
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ TemplateHelper::formatPrice($data['total']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-0">
                    <div
                        class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                        <div class="mb-8">
                            <span
                                class="badge badge-light-{{ $data['approved'] ? 'success' : 'danger' }} me-2">{{ $data['approved'] ? __('Approved') : __('Not approved') }}</span>
                            @if ($data['approved'])
                                <span
                                    class="badge badge-light-{{ $data['paid'] ? 'success' : 'warning' }}">{{ $data['paid'] ? __('Done') : __('Pending Payment') }}</span>
                            @endif
                        </div>
                        <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">{{ __('PAYMENT DETAILS') }}</h6>
                        <div class="mb-6">
                            <div class="fw-semibold text-gray-600 fs-7">{{ __('Paypal') }}:</div>
                            <div class="fw-bold text-gray-800 fs-6">{{ $data['paypal'] }}</div>
                        </div>
                        <div class="mb-6">
                            <div class="fw-semibold text-gray-600 fs-7">{{ __('Account') }}:</div>
                            <div class="fw-bold text-gray-800 fs-6">
                                {{ $data['account'] }}
                            </div>
                        </div>
                        <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">{{ __('PROJECT OVERVIEW') }}</h6>
                        <div class="mb-6">
                            <div class="fw-semibold text-gray-600 fs-7">{{ __('Project Name') }}</div>
                            <div class="fw-bold fs-6 text-gray-800">{{ $data['project-name'] }}
                                {{-- <a href="#" class="link-primary ps-1">View Project</a> --}}
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="fw-semibold text-gray-600 fs-7">{{ __('Completed By') }}:</div>
                            <div class="fw-bold text-gray-800 fs-6">{{ $data['completed-by'] }}</div>
                        </div>
                        <div class="m-0">
                            <div class="fw-semibold text-gray-600 fs-7">{{ __('Time Spent') }}:</div>
                            <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">{{ $data['time-spent'] }}
                                Hours
                                <span class="fs-7 text-success d-flex align-items-center">
                                    <span
                                        class="bullet bullet-dot bg-success mx-2"></span>{{ TemplateHelper::formatPrice($data['rate-hour'], 0) }}/h
                                    {{ __('Rate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
