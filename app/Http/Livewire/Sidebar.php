<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $title;
    public $logo;
    public $header = [];
    public $items = [];
    public $footer = [];

    public $iconIndex = 'fa';

    public $options = [
        'old' => -1,
    ];

    // Header => [
    //     'title' => 'App',
    //     'icon' => 'home',
    //     'logo' => '/demo1/media/logos/default-dark.svg',
    //     'small-logo' => '/demo1/media/logos/default-small.svg',
    //     'link' => '/',
    //     'route' => [
    //         'name' => 'test.posts',
    //     ],
    // ],
    // Menu => [
    //     'title' => 'Contact',
    //     'icon' => 'address-book',
    //     'show' => true,
    //     'link' => '/contacts',
    //     'route' => [
    //         'name' => 'test.menu',
    //         'params' => [
    //             'id' => 1,
    //             'contact' => 10,
    //         ],
    //     ],
    // ],

    public function render()
    {
        $this->init_sidebar_items();
        return view('livewire.templates.sidebar');
    }

    private function init_sidebar_items()
    {
        $this->header['href'] = $this->get_link($this->header);
        $this->footer['href'] = $this->get_link($this->footer);

        foreach ($this->items as $key => $item) {
            $this->items[$key]['infos'] = $this->get_menu_helpers($item, $key);
            $item['infos'] = $this->items[$key]['infos'];

            if ($item['infos']['children_exist']) {
                foreach ($item['children'] as $key_2 => $child) {
                    $this->items[$key]['children'][$key_2]['infos'] = $this->get_menu_helpers($child);
                    $child['infos'] = $this->items[$key]['children'][$key_2]['infos'];
                    $this->items[$key]['children'][$key_2]['infos']['is_current_url'] = $this->get_active_menu_link($child['infos']['href'], $key);
                }
            } else {
                $this->items[$key]['infos']['is_current_url'] = $this->get_active_menu_link($item['infos']['href'], $key);
            }
        }
    }

    public function action_sub($key)
    {
        if ($this->options['old'] == $key) {
            $this->options['old'] = -1;
            return;
        }

        $this->options['old'] = $key;
    }

    public function get_menu_helpers($item, $key = null)
    {
        $result = [
            'href' => '',
            'tag' => 'a',
            'menu_item_class' => '',
            'children_exist' => false,
            'active' => 'active',
        ];

        $result['href'] = $this->get_link($item);

        if (isset($item['children']) && gettype($item['children']) == 'array') {
            $result['tag'] = 'div';
            $result['active'] = 'hover show';
            $result['children_exist'] = true;
            if ($key != null) {
                $result['menu_item_class'] = 'menu-accordion ' . ($key == $this->options['old'] ? 'hover show' : '');
            }
        }

        return $result;
    }

    private function get_link($item)
    {
        $href = '';

        if (isset($item['link']) && !empty($item['link'])) {
            $href = asset($item['link']);
        } else if (isset($item['route']) && gettype($item['route']) == 'array') {
            $name = '';
            if (isset($item['route']['name']) && !empty($item['route']['name'])) {
                $name = $item['route']['name'];
                if (isset($item['route']['params']) && gettype($item['route']['params']) == 'array') {
                    $href = route($name, $item['route']['params']);
                } else {
                    $href = route($name);
                }
            }
        } else if (isset($item['default-url']) && !empty($item['default-url'])) {
            $href = asset($item['default-url']);
        }

        return $href;
    }

    private function get_active_menu_link($url, $key)
    {
        $is_current_url = $this->is_current_url($url);

        if ($is_current_url) {
            $this->options['old'] = $key;
        }

        return $is_current_url;
    }

    public function is_current_url($url)
    {
        $currentURL = url()->current();
        return $currentURL == $url;
    }
}
