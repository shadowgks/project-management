<?php

namespace App\Http\Livewire;

use App\Helpers\SettingsHelper;
use App\Core\Adapters\Theme;
use App\Core\Data;
use Livewire\Component;

class AppSetting extends Component
{
    public $base_data = [
        'keys' => ['app_logo', 'app_dark_logo', 'app_favicon', 'app_name', 'theme', 'app_language', 'app_timezone'],
        'themes' => [],
        'languages' => [],
        'time_zones' => [],
        'communications' => [],
        'old_values' => [
            'app_logo' => '',
            'app_dark_logo' => '',
            'app_favicon' => '',
            'app_name' => '',
            'theme' => '',
            'app_language' => '',
            'app_timezone' => '',
            'communication' => [],
            'allow_marketing' => false,
        ],
        'menuElements' => [
            [
                'name' => 'general_settings',
            ],
            [
                'name' => 'tab_settings_2',
            ],
            [
                'name' => 'tab_settings_3',
            ],
            [
                'name' => 'tab_settings_4',
            ],
        ],
        'theme_path' => '',
        'settings' => null,
    ];

    public $values = [
        'app_logo' => '',
        'app_dark_logo' => '',
        'app_favicon' => '',
        'app_name' => '',
        'theme' => '',
        'app_language' => '',
        'app_timezone' => '',
        'communication' => [],
        'allow_marketing' => false,
    ];

    public $options = [
        'selectedTab' => 0,
    ];

    public function render()
    {
        return view('livewire.settings.app-setting');
    }

    public function mount()
    {
        $settings = SettingsHelper::get_many_settings($this->base_data['keys']);

        array_walk($this->base_data['keys'], function ($key) use ($settings) {
            $this->values[$key] = $settings[$key]['value'];
            $this->base_data['old_values'][$key] = $settings[$key]['value'];
        });

        $this->base_data['settings'] = $settings;
        $this->base_data['themes'] = Theme::getOption('product', 'demos');
        $this->base_data['languages'] = Data::getLanguagesList();
        $this->base_data['time_zones'] = Data::getTimeZonesList();
        $this->base_data['theme_path'] = theme()->getMediaUrlPath();
        $this->base_data['communications'] = SettingsHelper::get_supported_data('communications');
    }

    public function select_tab($key)
    {
        $this->options['selectedTab'] = $key;
    }

    public function save_settings()
    {
        dd($this->values);
    }

    public function discard()
    {
        array_walk($this->base_data['keys'], function ($key) {
            $this->values[$key] = $this->base_data['old_values'][$key];
        });
    }
}
