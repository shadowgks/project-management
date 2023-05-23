@php
    use App\Helpers\TemplateHelper;
@endphp

<div class="card {!! $options['show_form'] ? '' : 'hidden' !!}">
    <div class="card-body p-12">
        <form action="" id="kt_invoice_form">
            <div class="d-flex flex-column align-items-start flex-xxl-row">
                <div class="d-flex align-items-center flex-equal fw-row me-4 order-2">
                    <div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('Date') }}:</div>
                    <div class="position-relative d-flex align-items-center w-150px">
                        <input class="form-control form-control-transparent fw-bold pe-5 flatpickr-input" type="date"
                            wire:model="form.date">
                        <i class="fa fa-chevron-down p-0"></i>
                    </div>
                </div>
                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4"
                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-original-title="Enter invoice number"
                    data-kt-initialized="1">
                    <span class="fs-2x fw-bold text-gray-800">{{ __('Invoice') }}</span>
                    @if ($options['id'] != null)
                        <span
                            class="fw-bold text-muted fs-3 w-125px mt-1 ms-2">{{ $options['currentElement']['code'] }}</span>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-original-title="Specify invoice due date"
                    data-kt-initialized="1">
                    <div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('Due Date') }}:</div>
                    <div class="position-relative d-flex align-items-center w-150px">
                        <input class="form-control form-control-transparent fw-bold pe-5 flatpickr-input" type="date"
                            wire:model="form.due-date">
                        <i class="fa fa-chevron-down p-0"></i>
                    </div>
                </div>
            </div>
            <div class="separator separator-dashed my-10"></div>
            <div class="mb-0">
                <div class="row gx-10 mb-5">
                    <div class="col-lg-6">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('Bill From') }}</label>
                        <div class="mb-5">
                            <input type="text" class="form-control form-control-solid" placeholder="Name"
                                wire:model.lazy="form.from.name">
                        </div>
                        <div class="mb-5">
                            <input type="text" class="form-control form-control-solid" placeholder="Email"
                                wire:model.lazy="form.from.email">
                        </div>
                        <div class="mb-5">
                            <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Who is this invoice from?"
                                wire:model.lazy="form.from.description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('Bill To') }}</label>
                        <div class="mb-5">
                            <input type="text" class="form-control form-control-solid" placeholder="Name"
                                wire:model.lazy="form.to.name">
                        </div>
                        <div class="mb-5">
                            <input type="text" class="form-control form-control-solid" placeholder="Email"
                                wire:model.lazy="form.to.email">
                        </div>
                        <div class="mb-5">
                            <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="What is this invoice for?"
                                wire:model.lazy="form.to.description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-10">
                    <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700">
                        <thead>
                            <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                <th class="min-w-300px w-475px">{{ __('Item') }}</th>
                                <th class="min-w-100px w-100px">{{ __('Quantity') }}</th>
                                <th class="min-w-150px w-150px">{{ __('Price') }}</th>
                                <th class="min-w-100px w-150px text-end">{{ __('Total') }}</th>
                                <th class="min-w-75px w-75px text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        @if ($itemsLength > 0)
                            <tbody>
                                @foreach ($form['items'] as $key => $item)
                                    <tr class="border-bottom border-bottom-dashed">
                                        <td class="pe-7">
                                            <input type="text" class="form-control form-control-solid mb-2"
                                                placeholder="Item name"
                                                wire:model.lazy="form.items.{{ $key }}.name">
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Description"
                                                wire:model.lazy="form.items.{{ $key }}.description">
                                        </td>
                                        <td class="ps-0">
                                            <input class="form-control form-control-solid" type="number" min="1"
                                                wire:model.lazy="form.items.{{ $key }}.quantity"
                                                wire:change="calculate">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-solid text-end"
                                                wire:model.lazy="form.items.{{ $key }}.price"
                                                wire:change="calculate">
                                        </td>
                                        <td class="pt-8 text-end text-nowrap">
                                            {{ TemplateHelper::formatPrice($item['quantity'] * $item['price']) }}
                                        </td>
                                        <td class="pt-5 text-end">
                                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                                                onclick="loadingVisibility(true)"
                                                wire:click="removeItem({{ $key }})">
                                                <i class="fa fa-trash p-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr data-kt-element="empty">
                                    <th colspan="5" class="text-muted text-center py-10">
                                        {{ __('No items') }}
                                    </th>
                                </tr>
                            </tbody>
                        @endif
                        <tfoot>
                            <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                <th class="text-primary">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="loadingVisibility(true)" wire:click="addItem">
                                        {{ __('Add item') }}
                                    </button>
                                </th>
                                {{-- <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                                            <div class="d-flex flex-column align-items-start">
                                                <div class="fs-5">{{ __('Subtotal') }}</div>
                                                <button type="button" class="btn btn-link py-1" onclick="loadingVisibility(true)">
                                                    {{ __('Add tax') }}
                                                </button>
                                                <button type="button" class="btn btn-link py-1" onclick="loadingVisibility(true)">
                                                    {{ __('Add discount') }}
                                                </button>
                                            </div>
                                        </th>
                                        <th colspan="2" class="border-bottom border-bottom-dashed text-end">$
                                            <span data-kt-element="sub-total">0.00</span>
                                        </th> --}}
                            </tr>
                            <tr class="align-top fw-bold text-gray-700">
                                <th></th>
                                <th colspan="2" class="fs-4 ps-0">{{ __('Total') }}</th>
                                <th colspan="2" class="text-end fs-4 text-nowrap">
                                    {{ TemplateHelper::formatPrice($form['total']) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mb-0">
                    <label class="form-label fs-6 fw-bold text-gray-700">{{ __('Notes') }}</label>
                    <textarea name="notes" class="form-control form-control-solid" rows="3"
                        placeholder="Thanks for your business" wire:model.lazy="form.notes"></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

@include('livewire.includes.base.form-buttons')
