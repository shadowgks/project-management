@php
    use Carbon\Carbon;
    $time = time();
@endphp

<div id="live-component">
    <div class="card card-flush">
        <div class="card-body">
            @include('livewire.module-includes.steps.numbering')
        </div>
    </div>

    <!-- NOTE - Settings -->
    <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
        route="{{ route($base_data['datatable']['route']) }}" />

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

                        changeOrderOfElement(variable);
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

        function changeOrderOfElement(variable) {
            let appModule = document.querySelector("#live-component");
            let wireId = appModule.getAttribute("wire:id");
            let component = Livewire.find(wireId);

            component.call("changeOrderOfElement", {
                variable: variable,
                elements: getOrderElements(variable),
            });
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
