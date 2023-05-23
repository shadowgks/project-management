<?php

namespace App\Http\Controllers;
use App\Models\PdfTemplates;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function index()
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
        $module=5;

        return view('pages.pdf_content', compact('module','groups','all_tags'));
    }
    public function store(Request $request)
    {
        $pdf = new PdfTemplates;
        $pdf->app_module_id = $request->app_module_id;
        $pdf->template = $request->template;
        $pdf->save();
        return redirect('add-pdf-form')->with('status', 'PDF Form Data Has Been inserted');
    }

    public function printData() {

        $data['app_module_id']=5;
        $data['module_id']=2;

        $pdf=PDF::loadView('pages.pdf_file',['data'=>$data]);

        // return $pdf->download('test.pdf');
        //afficher le fichier PDF dans le navigateur
        return $pdf->stream();

        $content=get_pdf_template(5,2);
        //print_r($content);

            $pdf = PDF::loadHTML($content);
            // $pdf = App::make('dompdf.wrapper');
            // $pdf->loadHTML($content);
            return $pdf->download('test.pdf');
    }
}
