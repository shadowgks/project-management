<div class="card card-flush">
    <div class="card-body">
        <div class="row m-0">
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('PDF') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" name="template_type"  id="template_type" wire:model="options.currentPdf" >
                    <option value="header">
                        {{ __('Header') }}
                    </option>
                    <option value="footer">
                        {{ __('Footer') }}
                    </option>
                </select>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Name') }}</span>
                </label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                    placeholder="{{ __('Name') }}" wire:model.lazy="values.name">
            </div>

            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Module') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.module_id">
                    <option disabled value="">
                        {{ __('Choose Module') }}
                    </option>
                    @foreach ($base_data['modules'] as $module)
                        <option value="{{ $module['id'] }}">
                            {{ $module['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-8">
                @if ($options['currentPdf'] == 'header')
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span>{{ __('Header') }}</span>
                    </label>
                    <div wire:ignore>
                        <textarea class="form-control form-control-lg form-control-solid" rows="7" name="header-content"
                            id="header_content" wire:model.lazy="values.header_content"></textarea>
                    </div>
                @else
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span>{{ __('Footer') }}</span>
                    </label>
                    <div wire:ignore>
                        <textarea class="form-control form-control-lg form-control-solid" rows="7" name="footer-content"
                            id="footer_content" wire:model.lazy="values.footer_content"></textarea>
                    </div>
                @endif
            </div>

            <div class="col-md-4 bg-secondary rounded">
                <div class="card card-flush my-4">
                    <div class="card-body">
                        @foreach ($base_data['tags'] as $key => $tag)
                            <button type="button" class="btn btn-primary btn-shadow w-100 rounded-0 mb-1"
                                {{ $key == $options['currentCategory'] ? 'disabled' : '' }}
                                wire:click="chooseCategory({{ $key }})">
                                {{ $tag['name'] }}
                                <i
                                    class="fa fa-{{ $key == $options['currentCategory'] ? 'angle-up' : 'angle-down' }} p-0"></i>
                            </button>

                            @if ($key == $options['currentCategory'])
                                <div class="py-6 px-2">
                                    @foreach ($tag['tags'] as $tg)
                                        <span class="py-3 px-4 bg-secondary"
                                            style="border-radius: 999px">{{ $tg }}</span>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-end my-3">
            <button type="button" class="btn btn-primary btn-shadow" wire:click="save">
                <i class="fa fa-check p-0"></i>
                {{ __('Save') }}
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#header_content'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('values.header_content', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#footer_content'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('values.footer_content', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
