<div id="live-component" wire:ignore>
    <button class="btn btn-primary btn-sm{{ $button ? '' : ' ' . 'hidden' }}"
        onclick="open_upload_dialog(this, 'upload{{ $_id == null ? '' : '-' . $_id }}')">
        <i class="fa fa-upload"></i>
        <span>{{ __('Upload') }}</span>
    </button>

    <div class="upload{{ $button ? ' ' . 'hidden' : '' }}{{ $class == null ? '' : ' ' . $class }}"
        id="upload{{ $_id == null ? '' : '-' . $_id }}">
        <div class="upload-files">
            <header>
                <p>
                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                    <span class="up">up</span>
                    <span class="load">load</span>
                </p>
            </header>

            <div class="body drop" id="drop{{ $_id == null ? '' : '-' . $_id }}"
                ondragleave="upload_drag_leave(this, 'upload{{ $_id == null ? '' : '-' . $_id }}')"
                ondragover="upload_drag_over(this, 'upload{{ $_id == null ? '' : '-' . $_id }}')"
                ondrop="upload_drag_drop(this, 'upload{{ $_id == null ? '' : '-' . $_id }}', '{{ $model }}', {{ $onchange == null ? null : '\'' . $onchange . '\'' }})">
                <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
                <p class="pointer-none"><b>Drag and drop</b> files here <br /> or <a
                        id="triggerFile{{ $_id == null ? '' : '-' . $_id }}"
                        onclick="open_upload_dialog(this, 'upload{{ $_id == null ? '' : '-' . $_id }}')">browse</a>
                    to begin the upload</p>
                <input class="upload-input" type="file" multiple="multiple" {{ $_id == null ? '' : 'id=' . $_id }}
                    onchange="get_uploaded_files(this, 'upload{{ $_id == null ? '' : '-' . $_id }}', '{{ $model }}', {{ $onchange == null ? null : '\'' . $onchange . '\'' }})" />
            </div>

            <footer>
                <div class="divider">
                    <span>
                        <AR>{{ __('Files') }}</AR>
                    </span>
                </div>

                <div class="list-files"></div>

                <button type="button" class="importar"
                    onclick="importar_event(this, 'upload{{ $_id == null ? '' : '-' . $_id }}')">{{ __('Update Files') }}</button>
            </footer>
        </div>
    </div>
</div>
