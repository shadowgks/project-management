<div id="live-component">
    <div class="app-content flex-column-fluid">
        <div class="app-container container-fluid">
            <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
                route="{{ route($base_data['datatable']['route']) }}" />
        </div>
    </div>
</div>
