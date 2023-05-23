<style>
    #alert-layout {
        position: fixed;
        top: 7rem;
        right: 2rem;
    }

    #alert-icon {
        font-size: 1.2rem;
    }

    #alert-content {
        font-size: 1rem;
    }
</style>

<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="alert-layout">
    <div class="toast-header">
        <i class="fa p-0 me-4" id="alert-icon"></i>
        <strong class="me-auto" id="alert-title"></strong>
        {{-- <small></small> --}}
        <button type="button" class="btn-close" onclick="resetAlert()"></button>
    </div>
    <div class="toast-body text-white" id="alert-content"></div>
</div>
