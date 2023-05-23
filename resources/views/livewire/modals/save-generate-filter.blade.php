<div class="modal black-background-transparent fade {{ $options['show_modal'] ? 'show' : '' }}" id="modal-view"
    tabindex="-1" role="dialog" style="display: {{ $options['show_modal'] ? 'block' : 'none' }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save Filter</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Name of filter</label>
                        <input type="text" class="form-control" wire:model.lazy="values.name" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="save_settings">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click="action_modal('hide')">Close</button>
            </div>
        </div>
    </div>
</div>
