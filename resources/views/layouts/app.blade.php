<style>
    .black-background-transparent {
        background: rgba(20, 20, 20, .6) !important;
        z-index: 1099 !important;
    }

    .popover-back {
        position: relative;
    }

    .popover-back .popover {
        min-width: 300px;
        position: absolute;
        visibility: hidden;
    }

    .popover-back .top-popover {
        bottom: 100%;
        left: 50%;
    }

    .popover-back .left-popover {
        top: -5px;
        right: 105%;
    }

    .popover-back .bottom-popover {
        top: 100%;
        left: 50%;
    }

    .popover-back .right-popover {
        top: -5px;
        left: 105%;
    }

    .popover-back:hover .popover {
        visibility: visible;
    }

    .select2-container .select2-selection--single {
        height: auto !important;
    }

    .select2-container {
        z-index: 1099 !important;
    }

    .hidden {
        display: none !important;
    }

    .sticky-steps-buttons {
        width: calc(100% - var(--kt-app-sidebar-width));
        position: fixed !important;
        right: 0;
        bottom: 0;
    }

    @media (max-width: 991.98px) {
        .sticky-steps-buttons {
            width: 100%;
            position: fixed !important;
            right: 0;
            bottom: 0;
        }
    }
</style>

<x-base-layout>
    {{ $slot }}
    <livewire:slide-alert />
    <livewire:loading-page />
    <livewire:app-alert />

    @livewireScripts
</x-base-layout>
