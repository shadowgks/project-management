<?php

namespace App\Http\Livewire;
use App\Models\PdfTemplates;

use Illuminate\Http\Request;
use PDF;
use Artisan;
use Auth;
use Livewire\Component;

class PdfContent extends Component
{
    public function render()
    {
        $all_tags=[];
        $all_tags_grouped=[];
        $groups=[];
        $classes=get_class_names();
        foreach(get_class_names() as $class)
        {
            $class_tags=app($class)->get_all_tags();
            $all_tags=array_merge($all_tags,$class_tags);
            foreach($class_tags as $class_tag)
            {
                $key_group=get_fields_by_key($class_tag['key'],'variable','variable_templates','group');
                if(!in_array($key_group,$groups))
                {
                    array_push($groups,$key_group);
                }
            }
        }

        $all_tags=get_all_tags(3);
        $module=1;


        return view('pages.pdf_content', compact('module','groups','all_tags'));
    }


    public function store(Request $request)
    {
        $pdf = new PdfTemplates;
        $pdf->app_module_id = $request->app_module_id;
        $pdf->template = $request->template;
        $pdf->save();
        return redirect('pdf')->with('status', 'PDF Form Data Has Been inserted');
    }

    public function printData() {

        $data['app_module_id']=1;
        $data['module_id']=1;

        $pdf=PDF::loadView('pages.pdf_file',['data'=>$data]);

        // return $pdf->download('test.pdf');
        //afficher le fichier PDF dans le navigateur
        return $pdf->stream();

        // $content=get_pdf_te mplate(5,2);
        // //print_r($content);

        //     $pdf = PDF::loadHTML($content);
        //     // $pdf = App::make('dompdf.wrapper');
        //     // $pdf->loadHTML($content);
        //     return $pdf->download('test.pdf');
    }
}
