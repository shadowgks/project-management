@if ($showCards)
    <div class="row m-0">
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-primary" title="Active Projects" value="45"
            percentage="50" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-info" title="Second Projects" value="8"
            percentage="8" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-success" title="Projects Done" value="34"
            percentage="20" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-danger" title="Projects Unused" value="13"
            percentage="10" />
    </div>
@endif
