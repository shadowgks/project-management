document.addEventListener("DOMContentLoaded", () => {
    // initListener();

    // NOTE - Livewire hooks
    if (typeof (Livewire) != 'undefined' && Livewire != undefined && Livewire != null) {
        // Livewire.hook('component.initialized', (component) => { });
        Livewire.hook('element.initialized', (el, component) => {
            init_custom_attibute();

            base_data.initialized = true;
            reInitSelect2();
        });
        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            base_data.initialized = false;
        });
        Livewire.hook('element.updated', (el, component) => {
            // liveReloadElements();
            // initListener();
            // initSelect2();
            // console.log('yoooo');
            // init_custom_attibute();
        });
        // Livewire.hook('element.removed', (el, component) => { });
    }
});