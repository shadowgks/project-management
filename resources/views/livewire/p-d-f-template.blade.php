<div class="card card-flush">
    <div class="card-body">
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
                <select class="form-select form-control-lg form-control-solid" wire:model="values.module_id"  wire:change="get_tags()">
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

            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Header') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.header">
                    <option disabled value="">
                        {{ __('Choose Header') }}
                    </option>
                    @foreach ($base_data['headers'] as $header)
                        <option value="{{ $header['id'] }}">
                            {{ $header['title'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Footer') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.footer" >
                    <option disabled value="">
                        {{ __('Choose Footer') }}
                    </option>

                    @foreach ($base_data['footers'] as $footer)
                        <option value="{{ $footer['id'] }}">
                            {{ $footer['title'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Content') }}</span>
                </label>
                <div wire:ignore>
                    <textarea class="form-control form-control-lg form-control-solid" rows="7" name="content" id="content"
                        wire:model.lazy="values.content"></textarea>
                </div>
            </div>

            <div class="col-md-4 bg-secondary rounded">
                <div class="card card-flush my-4">
                    <div class="card-body">
                        @foreach ($base_data['tags'] as $tag)
                            <button type="button" class="btn btn-primary btn-shadow w-100 rounded-0 mb-1"
                                {{ $tag['name'] == $options['currentCategory'] ? 'disabled' : '' }}
                                wire:click="chooseCategory({{ $tag['name'] }})">
                                {{ $tag['name'] }}
                                <i
                                    class="fa fa-{{ $tag['name'] == $options['currentCategory'] ? 'angle-up' : 'angle-down' }} p-0"></i>
                            </button>


                                <div class="py-6 px-2">
                                    @foreach ($tag['tags'] as $tg)
                                    <?php $tag_detail=(array)$tg ?>
                                        <span class="py-3 px-4 bg-secondary"
                                            style="border-radius: 999px">{ {{ $tag_detail['name'] }} }</span>
                                    @endforeach
                                </div>

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
        .create(document.querySelector('#content'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('values.content', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
