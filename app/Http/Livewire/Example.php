<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Example extends Component
{
    public $colors = [
        'primary',
        'secondary',
        'success',
        'warning',
        'info',
        'danger',
    ];

    public $menu_items = [
        [
            'title' => 'Buttons',
            'tag' => 'button',
            'row-class' => 'mb-2',
            'colors' => true,
        ],
        [
            'title' => 'Dropdowns',
            'tag' => 'dropdown',
            'row-class' => 'row mb-2',
            'colors' => true,
        ],
        [
            'title' => 'Inputs',
            'tag' => [
                'input',
                'textarea',
                'select',
                'checkbox',
                'range',
                'radio',
                'switch-input',
                'checkbox-image',
                'radio-image',
            ],
            'tag-options' => [
                '_id="id" class="class" name="name" placeholder="Type here" _key="key"',
                '_id="id" class="class" name="name" _key="key"',
                '_id="id" class="class" name="name" data="Your data" _key="key"',
                '_id="id" class="class" name="name" _key="key"',
                '_id="id" class="class" name="name" _key="key"',
                '_id="id" class="class" name="name" _key="key"',
                '_id="id" class="class" name="name" _key="key"',
                '_id="id" class="class" name="name" _key="key" src="Your image"',
                '_id="id" class="class" name="name" _key="key" src="Your image"',
            ],
            'row-class' => 'row mb-2',
            'options' => [
                'class' => 'mb-2',
                'image-class' => 'mb-2 col-4',
                'placeholder' => 'Type here',
                'image-1' => 'https://preview.keenthemes.com/html/metronic/docs/assets/media/stock/600x400/img-1.jpg',
                'image-2' => 'https://preview.keenthemes.com/html/metronic/docs/assets/media/stock/600x400/img-2.jpg',
            ],
        ],
        [
            'title' => 'Alerts',
            'tag' => 'alert',
            'row-class' => 'row mb-2',
            'colors' => true,
            'options' => [
                'title' => 'This is an alert',
                'description' => 'The alert component can be used to highlight certain parts of your page for higher content visibility.',
            ],
            'tag-options' => '_id="id" class="class" name="name" _key="key"',
        ],
        [
            'title' => 'Cards',
            'tag' => 'card',
            'row-class' => 'mb-2',
            'colors' => true,
            'options' => [
                'content' => '
                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-light">
                            Action
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    Lorem Ipsum is simply dummy text...
                </div>
                <div class="card-footer">
                    Footer
                </div>',
            ],
            'tag-options' => '_id="id" class="class" name="name" _key="key"',
        ],
    ];

    public $classes = [
        '',
        '-light',
        '-hover-light',
        '-outline',
        '-link',
    ];

    public $dropdown_data = [
        [
            'title' => 'Action',
            'link' => '#',
        ],
        [
            'title' => 'Another action',
            'link' => '#',
        ],
        [
            'title' => 'Something else here',
            'link' => '#',
        ],
    ];

    public $select_data = [
        [
            'id' => 1,
            'text' => 'option 1',
        ],
        [
            'id' => 2,
            'text' => 'option 2',
        ],
        [
            'id' => 3,
            'text' => 'option 3',
        ],
    ];

    public $selected_layout = 0;

    public function render()
    {
        return view('livewire.example');
    }

    public function generateHtml($element)
    {
        return '&lt;' . $element . ' /&gt;';
    }

    public function changeLayout($index)
    {
        if ($this->selected_layout == $index) return;
        $this->selected_layout = $index;
    }
}
