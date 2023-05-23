@php
    use App\Helpers\TemplateHelper;
    $countElements = count($values['sub_elements']);
@endphp

<div class="card card-flush" id="live-component">
    <div class="card-body" id="lv-menu">
        <!-- NOTE - Form -->
        @if ($appOptions['visible'])
            <div class="w-100">
                <div class="row m-0">
                    <div class="col-md-4 mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2 required">
                            <span>{{ __('Category') }}</span>
                        </label>

                        <select class="form-select form-control-lg form-control-solid" wire:model="values.category">
                            <option disabled value="">{{ __('Choose category') }}</option>
                            @foreach ($base_data['categories'] as $category)
                                <option value="{{ $category['id'] }}">{{ __($category['name']) }}
                                </option>
                            @endforeach
                        </select>
                        @error('values.category')
                            {!! TemplateHelper::getFormMessage($message) !!}
                        @enderror
                    </div>

                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">{{ __('Name') }}</span>
                        </label>
                        <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                            placeholder="{{ __('Name') }}" wire:model.lazy="values.name">
                        @error('values.name')
                            {!! TemplateHelper::getFormMessage($message) !!}
                        @enderror
                    </div>

                    @if ($values['category'] != 'separator')
                        <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Icon') }}</span>
                            </label>
                            <input type="text" class="form-control form-control-lg form-control-solid" name="icon"
                                placeholder="{{ __('Icon') }}" wire:model.lazy="values.icon">
                            {{-- @error('values.icon')
                                {!! TemplateHelper::getFormMessage($message) !!}
                            @enderror --}}
                        </div>
                    @endif

                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span>{{ __('Order') }}</span>
                        </label>

                        <select class="form-select form-control-lg form-control-solid" wire:model="values.item_order">
                            <option disabled value="">{{ __('Choose order') }}</option>
                            @foreach ($base_data['orders'] as $key => $order)
                                <option value="{{ $key + 1 }}">{{ __('order') . ' - ' . ($key + 1) }}
                                </option>
                            @endforeach
                        </select>
                        {{-- @error('values.item_order')
                            {!! TemplateHelper::getFormMessage($message) !!}
                        @enderror --}}
                    </div>

                    @if ($values['category'] != 'separator')
                        <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Permission') }}</span>
                            </label>

                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="values.permission_id">
                                <option disabled value="">{{ __('Choose permission') }}</option>
                                @foreach ($base_data['permissions'] as $permission)
                                    <option value="{{ $permission['id'] }}">{{ __($permission['pseudo_name']) }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- @error('values.source')
                                {!! TemplateHelper::getFormMessage($message) !!}
                            @enderror --}}
                        </div>
                    @endif

                    @if (in_array($values['category'], ['dropdown']))
                        <div class="w-100">
                            @if ($countElements > 0)
                                <div class="px-4 py-1 bg-secondary rounded">
                                    @foreach ($values['sub_elements'] as $key => $element)
                                        <div class="card card-flush my-4">
                                            <div class="card-header pt-5">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-dark">{{ __('Element') }} -
                                                        {{ $key + 1 }}</span>
                                                </h3>

                                                <div class="card-toolbar">
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="removeSubMenu({{ $key }})">
                                                        <i class="fa fa-trash p-0"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row m-0">
                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span class="required">{{ __('Name') }}</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="name" placeholder="{{ __('Name') }}"
                                                            wire:model.lazy="values.sub_elements.{{ $key }}.name">
                                                        @error('values.sub_elements.{{ $key }}.name')
                                                            {!! TemplateHelper::getFormMessage($message) !!}
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span>{{ __('Icon') }}</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="icon" placeholder="{{ __('Icon') }}"
                                                            wire:model.lazy="values.sub_elements.{{ $key }}.icon">
                                                        {{-- @error('values.sub_elements.{{ $key }}.icon')
                                                            {!! TemplateHelper::getFormMessage($message) !!}
                                                        @enderror --}}
                                                    </div>

                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span>{{ __('Path') }}</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="path" placeholder="{{ __('Path') }}"
                                                            wire:model.lazy="values.sub_elements.{{ $key }}.path">
                                                        {{-- @error('values.sub_elements.{{ $key }}.path')
                                                            {!! TemplateHelper::getFormMessage($message) !!}
                                                        @enderror --}}
                                                    </div>

                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span>{{ __('Order') }}</span>
                                                        </label>

                                                        <select class="form-select form-control-lg form-control-solid"
                                                            wire:model="values.sub_elements.{{ $key }}.item_order"
                                                            wire:change="checkElementOrder({{ $key }})">
                                                            <option disabled value="">{{ __('Choose order') }}
                                                            </option>
                                                            @for ($i = 0; $i < $countElements; $i++)
                                                                <option value="{{ $i + 1 }}">
                                                                    {{ __('order') . ' - ' . ($i + 1) }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span>{{ __('Permission') }}</span>
                                                        </label>

                                                        <select class="form-select form-control-lg form-control-solid"
                                                            wire:model="values.sub_elements.{{ $key }}.permission_id">
                                                            <option disabled value="">
                                                                {{ __('Choose permission') }}
                                                            </option>
                                                            @foreach ($base_data['permissions'] as $permission)
                                                                <option value="{{ $permission['id'] }}">
                                                                    {{ __($permission['pseudo_name']) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-row justify-content-end mt-4">
                            <button type="button" class="btn btn-lg btn-primary px-4 me-1" wire:click="addSubMenu">
                                <i class="fa fa-plus p-0"></i>
                                {{ __('Sub menu') }}
                            </button>
                        </div>
                    @else
                        @if ($values['category'] != 'separator')
                            <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Path') }}</span>
                                </label>
                                <input type="text" class="form-control form-control-lg form-control-solid"
                                    name="path" placeholder="{{ __('Path') }}" wire:model.lazy="values.path">
                                {{-- @error('values.path')
                                    {!! TemplateHelper::getFormMessage($message) !!}
                                @enderror --}}
                            </div>

                            @if ($values['category'] == 'sub_element')
                                <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span>{{ __('Source') }}</span>
                                    </label>

                                    <select class="form-select form-control-lg form-control-solid"
                                        wire:model="values.source">
                                        <option disabled value="">{{ __('Choose source') }}</option>
                                        @foreach ($base_data['sources'] as $source)
                                            <option value="{{ $source['id'] }}">{{ __($source['name']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- @error('values.source')
                                        {!! TemplateHelper::getFormMessage($message) !!}
                                    @enderror --}}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="d-flex flex-row justify-content-end mt-4">
                    <button type="button" class="btn btn-lg btn-primary px-4 me-1" wire:click="save">
                        {{ __('Save') }}
                    </button>

                    <button type="button" class="btn btn-lg btn-danger" wire:click="cancel">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        @else
            <div class="d-flex flex-row justify-content-end mt-4">
                <button type="button" class="btn btn-lg btn-primary btn-sm btn-shadow px-4 me-1"
                    wire:click="newMenu">
                    <i class="fa fa-plus p-0"></i>
                    {{ __('New') }}
                </button>
            </div>
        @endif

        <!-- NOTE - Items -->
        <div class="card card-bordered bg-secondary mt-10">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ __('Items') }}</h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row row-cols-1 g-10 draggable-zone">
                    @foreach ($base_data['data'] as $key => $item)
                        @if ($item['source'] == null)
                            <div class="col draggable"
                                data-item='{ "id": {{ $item['id'] }}, {!! $item['category'] == 'dropdown' ? '"parent": true' : '"parent": false' !!}, "order": {{ $key + 1 }} }'>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-between">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    <i class="fa fa-{{ $item['icon'] }} p-0"
                                                        style="font-size: 1.4rem"></i>
                                                    <span>{{ $item['name'] }}</span>
                                                </h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <a
                                                    class="btn btn-icon btn-sm btn-hover-light-primary draggable-handle">
                                                    <i class="fa-solid fa-arrows-up-down-left-right"></i>
                                                </a>
                                                <button class="btn btn-secondary btn-icon btn-sm"
                                                    wire:click="editData({{ $item['id'] }})">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-icon btn-sm"
                                                    wire:click="deleteData({{ $key }})">
                                                    <i class="fa fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-muted">{{ __($item['category']) }}</span>
                                    </div>
                                </div>
                            </div>

                            @if (count($item['subs']) > 0)
                                <div class="d-flex flex-column align-items-end mt-4">
                                    @foreach ($item['subs'] as $key_2 => $sub)
                                        <div class="col-md-11 mb-4 draggable"
                                            data-item='{ "id": {{ $sub['id'] }}, "child": true, "source": {{ $sub['source'] }}, "order": {{ $key_2 + 1 }} }'>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div class="card-title">
                                                            <h3 class="card-label">
                                                                <i class="fa fa-{{ $sub['icon'] }} p-0"
                                                                    style="font-size: 1.4rem"></i>
                                                                <span>{{ $sub['name'] }}</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-toolbar">
                                                            <a
                                                                class="btn btn-icon btn-sm btn-hover-light-primary draggable-handle">
                                                                <i class="fa-solid fa-arrows-up-down-left-right"></i>
                                                            </a>
                                                            <button class="btn btn-secondary btn-icon btn-sm"
                                                                wire:click="editData({{ $key }})">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-icon btn-sm"
                                                                wire:click="deleteData({{ $key }})">
                                                                <i class="fa fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="text-muted">{{ __($sub['category']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        const getItems = () => {
            let items = document.querySelectorAll("#lv-menu .draggable"),
                arrayHelper = [];

            for (const item of items) {
                let text = item.getAttribute("data-item"),
                    json = {};

                try {
                    json = JSON.parse(text);
                } catch (error) {
                    console.error(error);
                }

                arrayHelper.push(json);
            }

            return arrayHelper;
        }

        const changeOrder = (variable) => {
            let appModule = document.querySelector("#lv-menu");
            let wireId = appModule.getAttribute("wire:id");
            let component = Livewire.find(wireId);

            component.call("changeOrder", {
                items: getItems(),
            });
        }

        const initMenus = () => {
            var containers = document.querySelectorAll(".draggable-zone");

            if (containers.length === 0) {
                return false;
            }

            var swappable = new Swappable.default(containers, {
                draggable: ".draggable",
                handle: ".draggable .draggable-handle",
                mirror: {
                    //appendTo: selector,
                    appendTo: "body",
                    constrainDimensions: true
                }
            });

            // swappable.on('swappable:start', () => console.log('swappable:start'));
            // swappable.on('swappable:swap', () => console.log('swappable:swap'));
            // swappable.on('swappable:swapped', () => console.log('swappable:swapped'));
            swappable.on('swappable:stop', () => {
                loadingVisibility(true);

                setTimeout(() => {
                    let items = document.querySelectorAll("#lv-menu .draggable");
                    console.log(items);
                    liveCall("changeOrder", {
                        items: getItems(),
                    });
                    // changeOrder();
                    loadingVisibility(false);
                }, 1000);
            });
        }

        initMenus();
    </script>
@endsection
