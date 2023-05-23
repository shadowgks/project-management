@php
    use App\Helpers\ModelHelper;
    $time = time();
    $countTables = count($tables);
    $countRelations = count($values['relations']);
    $countFormFields = count($values['template']['fields']);
    $countValidations = count($values['validator']['validations']);
@endphp

<div id="live-component" class="position-relative">
    <!-- NOTE - App body -->
    <div class="card card-flush mt-5">
        <div class="card-body">
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                        data-kt-stepper="true">
                        <!-- NOTE - Steps header -->
                        <div
                            class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                            <div class="stepper-nav ps-lg-10">
                                <div class="stepper-item {{ $options['selected_step'] == 1 ? 'current' : '' }} {{ $options['selected_step'] > 1 ? 'completed' : '' }}"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">1</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Module</h3>
                                            <div class="stepper-desc">Name and details</div>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>

                                <div class="stepper-item {{ $options['selected_step'] == 2 ? 'current' : '' }} {{ $options['selected_step'] > 2 ? 'completed' : '' }}"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Database</h3>
                                            <div class="stepper-desc">Name and tables</div>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>

                                <div class="stepper-item {{ $options['selected_step'] == 3 ? 'current' : '' }} {{ $options['selected_step'] > 3 ? 'completed' : '' }}"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">3</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Relations</h3>
                                            <div class="stepper-desc">Relation of tables</div>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>

                                <div class="stepper-item {{ $options['selected_step'] == 4 ? 'current' : '' }} {{ $options['selected_step'] > 4 ? 'completed' : '' }}"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">4</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Templates</h3>
                                            <div class="stepper-desc">Make templates</div>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>

                                @if ($countTables > 0 && $this->tables[0]['table_contain_numbering'])
                                    <div class="stepper-item {{ $options['selected_step'] == 5 ? 'current' : '' }} {{ $options['selected_step'] > 5 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">5</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Numbering</h3>
                                                <div class="stepper-desc">Setup numbering</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                @if ($countTables > 0 && $this->tables[0]['table_contain_barcode'])
                                    <div class="stepper-item {{ $options['selected_step'] == 6 ? 'current' : '' }} {{ $options['selected_step'] > 6 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">6</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Barcode</h3>
                                                <div class="stepper-desc">Setup barcode</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                @if ($values['module']['notifications'])
                                    <div class="stepper-item {{ $options['selected_step'] == 7 ? 'current' : '' }} {{ $options['selected_step'] > 7 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">7</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Notifications</h3>
                                                <div class="stepper-desc">Setup notifications of application</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                @if ($values['module']['emailing'])
                                    <div class="stepper-item {{ $options['selected_step'] == 8 ? 'current' : '' }} {{ $options['selected_step'] > 8 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">8</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Emails</h3>
                                                <div class="stepper-desc">Setup emails of application</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                @if ($values['module']['pdf'])
                                    <div class="stepper-item {{ $options['selected_step'] == 9 ? 'current' : '' }} {{ $options['selected_step'] > 9 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">9</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">PDF</h3>
                                                <div class="stepper-desc">Setup PDF configurations</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                @if ($values['module']['contain_validator'])
                                    <div class="stepper-item {{ $options['selected_step'] == 10 ? 'current' : '' }} {{ $options['selected_step'] > 10 ? 'completed' : '' }}"
                                        data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">10</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Validator</h3>
                                                <div class="stepper-desc">Setup validator configurations</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                @endif

                                <div class="stepper-item {{ $options['selected_step'] == 11 ? 'current' : '' }} {{ $options['selected_step'] > 11 ? 'completed' : '' }}"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">11</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Listing</h3>
                                            <div class="stepper-desc">Setup listing configurations</div>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>

                                <div class="stepper-item {{ $options['selected_step'] == 12 ? 'current' : '' }} mark-completed"
                                    data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">12</span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Completed</h3>
                                            <div class="stepper-desc">Preview and Save</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- NOTE - Steps body -->
                        <div class="flex-row-fluid py-lg-5 px-lg-15" style="position: relative;">
                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                                id="kt_modal_create_app_form">

                                <!-- NOTE - Module step -->
                                <div class="{{ $options['selected_step'] == 1 ? 'current' : 'pending' }} mb-12"
                                    data-kt-stepper-element="content">
                                    @include('livewire.module-includes.steps.home')
                                </div>

                                <!-- NOTE - Tables step -->
                                <div class="{{ $options['selected_step'] == 2 ? 'current' : 'pending' }} mb-12"
                                    data-kt-stepper-element="content">
                                    @include('livewire.module-includes.steps.tables')
                                </div>

                                <!-- NOTE - Relations step -->
                                <div class="{{ $options['selected_step'] == 3 ? 'current' : 'pending' }} mb-12"
                                    data-kt-stepper-element="content">
                                    @include('livewire.module-includes.steps.relations')
                                </div>

                                <!-- NOTE - Templates step -->
                                <div class="{{ $options['selected_step'] == 4 ? 'current' : 'pending' }} mb-12"
                                    data-kt-stepper-element="content">
                                    @include('livewire.module-includes.steps.templates')
                                </div>

                                <!-- NOTE - Numbering step -->
                                @if ($countTables > 0 && $this->tables[0]['table_contain_numbering'])
                                    <div class="{{ $options['selected_step'] == 5 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        @include('livewire.module-includes.steps.numbering')
                                    </div>
                                @endif

                                <!-- NOTE - Barcode step -->
                                @if ($countTables > 0 && $this->tables[0]['table_contain_barcode'])
                                    <div class="{{ $options['selected_step'] == 6 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        @include('livewire.module-includes.steps.barcode')
                                    </div>
                                @endif

                                <!-- NOTE - Notifications step -->
                                @if ($values['module']['notifications'])
                                    <div class="{{ $options['selected_step'] == 7 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        <div class="w-100">
                                            @include('livewire.module-includes.steps.notification')
                                        </div>
                                    </div>
                                @endif

                                <!-- NOTE - Emails step -->
                                @if ($values['module']['emailing'])
                                    <div class="{{ $options['selected_step'] == 8 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        <div class="w-100">
                                        </div>
                                    </div>
                                @endif

                                <!-- NOTE - PDF step -->
                                @if ($values['module']['pdf'])
                                    <div class="{{ $options['selected_step'] == 9 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        <div class="w-100">
                                        </div>
                                    </div>
                                @endif

                                <!-- NOTE - Validator step -->
                                @if ($values['module']['contain_validator'])
                                    <div class="{{ $options['selected_step'] == 10 ? 'current' : 'pending' }} mb-12"
                                        data-kt-stepper-element="content">
                                        <div class="w-100">
                                            @include('livewire.module-includes.steps.validators')
                                        </div>
                                    </div>
                                @endif

                                <div class="{{ $options['selected_step'] == 11 ? 'current' : 'pending' }} mb-12"
                                    data-kt-stepper-element="content">
                                    <div class="w-100">
                                        @include('livewire.module-includes.steps.listing')
                                    </div>
                                </div>

                                <div class="{{ $options['selected_step'] == 12 ? 'current' : 'pending' }}"
                                    data-kt-stepper-element="content">
                                    <div class="w-100 text-center">
                                        <h1 class="fw-bold text-dark mb-3">Release!</h1>
                                        <div class="text-muted fw-semibold fs-3">Submit your app to kickstart your
                                            project.
                                        </div>
                                        <div class="text-center px-4 py-15">
                                            <img src="/metronic8/demo1/assets/media/illustrations/sketchy-1/9.png"
                                                alt="" class="mw-100 mh-300px">
                                        </div>
                                    </div>
                                </div>

                                <!-- NOTE - Actions -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-sticky d-flex flex-row flex-stack mt-10 p-6 bg-white sticky-steps-buttons">
        <div class="me-2">
            @if ($options['selected_step'] > 1)
                <button type="button" class="btn btn-lg btn-light-primary me-3"
                    wire:click="action_step('previous')">
                    <span class="svg-icon svg-icon-3 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="11" width="13" height="2"
                                rx="1" fill="currentColor"></rect>
                            <path
                                d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>Back
                </button>
            @endif
        </div>

        <div>
            <button type="button" class="btn btn-lg btn-danger" wire:click="cancel">
                Cancel
            </button>

            @if ($options['selected_step'] == 12)
                <button type="button" class="btn btn-lg btn-success px-4 me-1" wire:click="saveModule">
                    Save
                </button>
            @endif

            @if ($options['selected_step'] < 12)
                <button type="button" class="btn btn-lg btn-primary" wire:click="action_step('next')">Continue
                    <span class="svg-icon svg-icon-3 ms-1 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)" fill="currentColor">
                            </rect>
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                </button>
            @endif
        </div>
    </div>

    @if ($options['alert']['show'])
        <livewire:app-alert :type="$options['alert']['type']" :content="$options['alert']['content']" />
    @endif

    <script>
        var numberingElements = document.querySelectorAll(".numbering-drag-element"),
            barcodeElements = document.querySelectorAll(".barcode-drag-element");

        function initElements(allElements, variable) {
            if (allElements.length > 0) {
                for (const element of allElements) {
                    element.addEventListener("dragstart", e => {
                        let elem = e.target;
                        elem.setAttribute('dragging', true);
                    });

                    element.addEventListener("drop", e => {
                        let elem = e.target,
                            dragginElem = document.querySelector("[dragging]"),
                            newElemParent = dragginElem.parentElement,
                            newDragginElemParent = elem.parentElement;
                        let className = getClassName(elem.classList[2]);
                        elem.classList.remove(className.hoverClassName);

                        if (elem.getAttribute("data-id") == dragginElem.getAttribute("data-id")) {
                            return;
                        }

                        replaceDraggedElement(newElemParent, elem);
                        replaceDraggedElement(newDragginElemParent, dragginElem);

                        liveCall("changeOrderOfElement", {
                            variable: variable,
                            elements: getOrderElements(variable),
                        });
                    });

                    element.addEventListener("dragenter", e => {
                        let elem = e.target,
                            className = getClassName(elem.classList[2]);
                        elem.classList.add(className.hoverClassName);
                        e.preventDefault();
                    });

                    element.addEventListener("dragover", e => e.preventDefault());

                    element.addEventListener("dragleave", e => {
                        let elem = e.target,
                            className = getClassName(elem.classList[2]);
                        elem.classList.remove(className.hoverClassName);
                    });

                    element.addEventListener("dragend", e => {
                        let elem = e.target;
                        elem.removeAttribute('dragging');
                    });
                }
            }
        }

        function createDraggedElement(child) {
            let newElement = document.createElement("div")
            newElement.classList.add("p-1");
            newElement.style.cursor = "move";
            newElement.appendChild(child);

            return newElement;
        }

        function getClassName(className) {
            let classContent = className.split("-");

            return {
                className: className,
                hoverClassName: `${classContent[0]}-light-${classContent[1]}`,
            };
        }

        function replaceDraggedElement(parent, child) {
            parent.innerHTML = "";
            parent.appendChild(child);
        }

        function getOrderElements(variable) {
            let elements = document.querySelectorAll(`.${variable}-drag-element`),
                arrayHelper = [];

            for (const element of elements) {
                let key = element.getAttribute("data-id");
                arrayHelper.push(key);
            }

            return arrayHelper;
        }

        window.addEventListener('load', () => {
            initElements(numberingElements, "numbering");
            initElements(barcodeElements, "barcode");
        })

        document.addEventListener('elementsChanged', function(data) {
            numberingElements = document.querySelectorAll(".numbering-drag-element");
            barcodeElements = document.querySelectorAll(".barcode-drag-element");

            initElements(numberingElements, "numbering");
            initElements(barcodeElements, "barcode");
        });
    </script>
</div>
