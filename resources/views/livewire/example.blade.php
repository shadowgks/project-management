<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="card card-docs flex-row-fluid mb-2">
                <div class="card-body fs-6 py-6 px-6 text-gray-700">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav flex-column nav-pills">
                                @foreach ($menu_items as $key => $item)
                                    <li class="nav-item" style="cursor: pointer">
                                        <a class="nav-link py-4 {{ $selected_layout == $key ? 'active' : '' }}" wire:click="changeLayout({{ $key }})">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container col-md-10 d-flex flex-column flex-lg-row">
            <div class="card card-docs flex-row-fluid mb-2">
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
                    @foreach ($menu_items as $key => $item)
                        @if ($selected_layout == $key)
                            <div>
                                @if (isset($item['colors']) && $item['colors'])
                                    @foreach ($classes as $class)
                                        <div class="{{ $item['row-class'] }}">
                                            @foreach ($colors as $color)
                                                @if ($item['tag'] == 'button')
                                                    <livewire:button class="btn{{ $class }}-{{ $color }} me-2" title="{{ $color }}" />
                                                @elseif ($item['tag'] == 'dropdown')
                                                    <livewire:dropdown class="col-md-2" buttonClass="btn{{ $class }}-{{ $color }} me-2" title="{{ $color }}" :data="$dropdown_data" />                                                
                                                @elseif ($item['tag'] == 'alert')
                                                    <livewire:alert class="bg{{ $class }}-{{ $color }} mb-2" _id="{{ $item['tag'] . '-' . $key }}" _key="{{ $item['tag'] . '-' . $key }}"  title="{{ $item['options']['title'] . ' ' . $color }}" description="{{ $item['options']['description'] }}" />
                                                @elseif ($item['tag'] == 'card')
                                                    <livewire:card class="bg{{ $class }}-{{ $color }} mb-2" content="{!! $item['options']['content'] !!}" />
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="highlight my-4">
                                            @foreach ($colors as $color)
                                                <p class="text-{{ $color }}">{!! $this->generateHtml('livewire:' . $item['tag'] . ' class="btn' . $class . '-' . $color . '" title="' . $color . '"') !!}</p>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @else
                                    @if (gettype($item['tag']) == 'array')
                                        @foreach ($item['tag'] as $key_tag => $tag)
                                            @if ($tag == 'input')
                                                <livewire:input _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" placeholder="{{ $item['options']['placeholder'] }}" _key="{{ $tag . '-' . $key }}" />
                                            @elseif ($tag == 'textarea')
                                                <livewire:textarea _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" _key="{{ $tag . '-' . $key }}" />
                                            @elseif ($tag == 'checkbox')
                                                <livewire:checkbox _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" _key="{{ $tag . '-' . $key }}" />
                                                <livewire:checkbox _id="{{ $tag . '-1-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-1-' . $key }}" _key="{{ $tag . '-1-' . $key }}" />
                                            @elseif ($tag == 'range')
                                                <livewire:range _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" _key="{{ $tag . '-' . $key }}" />
                                            @elseif ($tag == 'radio')
                                                <livewire:radio _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" _key="{{ $tag . '-' . $key }}" />
                                                <livewire:radio _id="{{ $tag . '-1-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-1-' . $key }}" _key="{{ $tag . '-1-' . $key }}" />
                                            @elseif ($tag == 'select')
                                                <livewire:select _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" :data="$select_data" _key="{{ $tag . '-' . $key }}" />
                                            @elseif ($tag == 'switch-input')
                                                <livewire:switch-input _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['class'] }}" name="{{ $tag . '-' . $key }}" _key="{{ $tag . '-' . $key }}" />
                                            @elseif ($tag == 'checkbox-image')
                                                <livewire:checkbox-image _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['image-class'] }}" name="{{ $tag . '-' . $key }}" src="{{ $item['options']['image-1'] }}" _key="{{ $tag . '-' . $key }}" />
                                                <livewire:checkbox-image _id="{{ $tag . '-1-' . $key }}" class="{{ $item['options']['image-class'] }}" name="{{ $tag . '-1-' . $key }}" src="{{ $item['options']['image-2'] }}" _key="{{ $tag . '-1-' . $key }}" />
                                            @elseif ($tag == 'radio-image')
                                                <livewire:radio-image _id="{{ $tag . '-' . $key }}" class="{{ $item['options']['image-class'] }}" name="{{ $tag . '-' . $key }}" src="{{ $item['options']['image-1'] }}" _key="{{ $tag . '-' . $key }}" />
                                                <livewire:radio-image _id="{{ $tag . '-1-' . $key }}" class="{{ $item['options']['image-class'] }}" name="{{ $tag . '-1-' . $key }}" src="{{ $item['options']['image-2'] }}" _key="{{ $tag . '-1-' . $key }}" />
                                            @endif
        
                                            <div class="highlight my-4">
                                                <p class="text-primary">{!! $this->generateHtml('livewire:' . $tag . ' ' . $item['tag-options'][$key_tag]) !!}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="highlight my-4">
                                            <p class="text-primary">{!! $this->generateHtml('livewire:' . $item['tag'] . ' ' . $item['tag-options']) !!}</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>