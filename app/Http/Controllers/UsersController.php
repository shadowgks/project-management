<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class UsersController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = theme()->getOption('page');

        //$data=get_merge_fields_values(1,3,1);
      // $data=get_pdf_template(1,1);
        $data=get_all_tags_by_group(3);
        dd($data);
        die();

        $file = config('maileclipse.mailables_dir').'templates.json';
        $data=json_decode(file_get_contents($file));
        print_r($data);
        die();

        $data['date']="2023-01-02";
        $data['reference']= $this->get_barcode(1,$data['date']);
        $this->update_barcode_assignement_number(1,$data['date']);


      // $data= $this->get_validation_steps(4);

        print_r($data);
        die();
       // $code=get_module_code('users',2);
     //  $code=$this->get_validation_steps('users');
   //     $code=$this->save_validation_recordings('users',2,111,2,1,'test');
    //    $code=$this->get_numbering('users');
    //    print_r($code);
    //    $this->update_assignement_number('users');
      //  $code=get_merge_fields(2,'app_module_ids',2);
      $code=get_pdf_template('users',2);
        print_r($code);
        die();
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $config = theme()->getOption('page');

        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = theme()->getOption('page', 'edit');

        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
