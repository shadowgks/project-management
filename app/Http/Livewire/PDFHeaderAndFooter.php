<?php

namespace App\Http\Livewire;

use App\Models\AppModule;
use App\Traits\AppTrait;
use Livewire\Component;
use DB;
use Auth;

class PDFHeaderAndFooter extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'tags' => [],
        'modules' => [],
    ];

    public $values = [
        'name' => '',
        'module_id' => '',
        'header_content' => '',
        'footer_content' => '',
    ];

    public $options = [
        'currentCategory' => 0,
        'currentPdf' => 'header',
    ];

    public function render()
    {
        return view('livewire.p-d-f-header-and-footer');
    }

    public function mount()
    {
        $this->base_data['modules'] = AppModule::orderBy('id')->get();
        $this->base_data['tags'] = [
            [
                'name' => 'App',
                'tags' => [
                    '{name}',
                    '{logo}',
                    '{date}',
                ]
            ],
            [
                'name' => 'Client',
                'tags' => [
                    '{name}',
                    '{logo}',
                    '{date}',
                ]
            ],
            [
                'name' => 'Supplier',
                'tags' => [
                    '{name}',
                    '{logo}',
                    '{date}',
                ]
            ],
        ];
    }

    // NOTE - Save
    public function save()
    {
        $this->req(function () {
            $data = $this->values;
            //dd($data);

            if ($data['header_content'] != '') {
                $content = $data['header_content'];
                $table = 'pdf_headers';
            }
            if ($data['footer_content'] != '') {
                $content = $data['footer_content'];
                $table = 'pdf_footers';
            }
            $app_id = get_fields_by_key($data['module_id'], 'id', 'app_modules', 'app_id');
            $success = DB::table($table)->insert([
                'title' => $data['name'],
                'app_id' => $app_id,
                'user_id' => Auth::id(),
                'content' => $content,

            ]);
            if ($success) {
                $this->showSlideAlert("success", "Added successfully");
            }
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            $this->hideAlert();
        });
    }

    public function chooseCategory($index)
    {
        $this->req(function () use ($index) {
            $this->options['currentCategory'] = $index;
        });
    }

    public function cancel()
    {
        $this->req(function () {
            foreach ($this->values as $key => $value) {
                $this->values[$key] = "";
            }
        });
    }
}
