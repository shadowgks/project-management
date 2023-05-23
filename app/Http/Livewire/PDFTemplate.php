<?php

namespace App\Http\Livewire;

use App\Models\AppModule;
use App\Traits\AppTrait;
use Livewire\Component;
use DB;

class PDFTemplate extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'tags' => [],
        'modules' => [],
        'headers' => [],
        'footers' => [],
    ];

    public $values = [
        'name' => '',
        'module_id' => '',
        'header' => '',
        'content' => '',
        'footer' => '',
    ];

    public $options = [
        'currentCategory' => -1,
    ];

    public function render()
    {
        return view('livewire.p-d-f-template');
    }

    public function mount()
    {
        $this->base_data['modules'] = AppModule::orderBy('id')->get();
        // $module_id=$this->values['module_id'];
        // $template_id=get_fields_by_key($module_id, 'app_module_id', 'pdf_templates', 'id');
        $this->base_data['tags'] = get_all_tags_by_group(0);
        //  [
        //     [
        //         'name' => 'App',
        //         'tags' => [
        //             '{name}',
        //             '{logo}',
        //             '{date}',
        //         ]
        //     ],
        //     [
        //         'name' => 'Client',
        //         'tags' => [
        //             '{name}',
        //             '{logo}',
        //             '{date}',
        //         ]
        //     ],
        //     [
        //         'name' => 'Supplier',
        //         'tags' => [
        //             '{name}',
        //             '{logo}',
        //             '{date}',
        //         ]
        //     ],
        // ];
        $headers = DB::table('pdf_headers')->get();
        foreach ($headers as $header) {
            array_push($this->base_data['headers'], (array)$header);
        }
        $footers = DB::table('pdf_footers')->get();
        foreach ($footers as $footer) {
            array_push($this->base_data['footers'], (array)$footer);
        }
    }

    // NOTE - Save
    public function save()
    {
        $this->req(function () {
            $data = $this->values;
            // dd($data);
            $success = DB::table('pdf_templates')->insert([
                'title' => $data['name'],
                'template' => $data['content'],
                'pdf_footer_id' => $data['footer'],
                'pdf_header_id' => $data['header'],
                'app_module_id' => $data['module_id'],
                // 'user_id' => Auth::id(),


            ]);

            $this->cancel();
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            $this->hideAlert();
        });
    }

    public function get_tags()
    {
        $this->req(function () {
            $module_id = $this->values['module_id'];
            $template_id = get_fields_by_key($module_id, 'app_module_id', 'pdf_templates', 'id');
            $this->base_data['tags'] = get_all_tags_by_group($template_id);
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
