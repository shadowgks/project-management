<x-card class="card-flush" :hastitle="true"  :hasfooter="false"  bodyclass="pt-5">
    <x-slot name="headerContent">
        <div class="card-title">
            <h2>Groups</h2>
        </div>
    </x-slot>
    
    <div class="d-flex flex-column gap-5">
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary active">Overview</a>
            <x-badge type="light-primary" message="9" />
        </div>
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">Projects</a>
            <x-badge type="light-primary" message="3" />
        </div>
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">Campaigns</a>
            <x-badge type="light-primary" message="1" />
        </div>
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">Documents</a>
            <x-badge type="light-primary" message="3" />
        </div>
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">Blocked</a>
            <x-badge type="light-primary" message="2" />
        </div>
        
        <div class="d-flex flex-stack">
            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">invoices</a>
            <x-badge type="light-primary" message="2" />
        </div>
        
    </div>
</x-card>
