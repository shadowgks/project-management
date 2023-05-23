<?php

namespace Modules\GeneralInformations\Database\Seeders;


            use Illuminate\Database\Seeder;
            use App\Models\AppModule;
            use Illuminate\Support\Facades\Artisan;
            use Illuminate\Support\Facades\DB;
            use App\Models\DropDown;use App\Models\Form;use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;

class GeneralInformationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            AppModule::create([
                "name" => "GeneralInformations",
            "pseudo_name" => "generalinformations",
            "description" => "",
            "empty_when_reinitializating" => 0,
            "emailing" => 0,
            "notifications" => 0,
            "pdf" => 0,
            "contain_validator" => 0,
            "activate_importation" => 0,
            "activate_file_upload" => 1,
            "activate_comments" => 1,
            "activate_reminders" => 1,
            "activate_duplicate" => 1,
            "namespace" => "Modules\GeneralInformations\Entities",
            "gate_id" => 1,
            "user_id" => 1,
            "app_id" => 1,
            "active" => 1,
            ]);
            $app_module_id = AppModule::where("pseudo_name","generalinformations")->first()->id;
            
                Artisan::call('permission:create generalinformations basic');
                Artisan::call('permission:create generalinformations advanced');
                DropDown::insert([
                            "select_table"=>"general_informations",
                            "select_field"=>"type",
                            "select_id"=>"1",
                            "select_value"=>"private",
                            "app_module_id"=>$app_module_id,
                            "user_id"=>1,
                        ]);DropDown::insert([
                            "select_table"=>"general_informations",
                            "select_field"=>"type",
                            "select_id"=>"2",
                            "select_value"=>"public",
                            "app_module_id"=>$app_module_id,
                            "user_id"=>1,
                        ]);Form::insert([
                "name"=>"GeneralInformations_basic_form",
                "app_module_id"=>$app_module_id,
                "user_id"=>1,
                "value"=>'a:5:{i:0;a:21:{s:6:"active";b:1;s:5:"order";i:0;s:5:"table";s:1:"0";s:6:"column";s:4:"name";s:5:"label";s:4:"Name";s:13:"design_length";s:1:"6";s:4:"type";s:4:"text";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:4:"Name";s:6:"length";i:255;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:1;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:0;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:1;a:21:{s:6:"active";b:1;s:5:"order";i:1;s:5:"table";s:1:"0";s:6:"column";s:4:"type";s:5:"label";s:4:"Type";s:13:"design_length";s:1:"6";s:4:"type";s:6:"select";s:5:"value";a:4:{s:4:"type";s:6:"custom";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:2:{i:0;a:3:{s:5:"value";s:1:"1";s:4:"text";s:7:"private";s:6:"errors";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}i:1;a:3:{s:5:"value";s:1:"2";s:4:"text";s:6:"public";s:6:"errors";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:1;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:0;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:2;a:21:{s:6:"active";b:1;s:5:"order";i:2;s:5:"table";s:1:"0";s:6:"column";s:10:"start_date";s:5:"label";s:10:"Start date";s:13:"design_length";s:1:"6";s:4:"type";s:8:"datetime";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:3;a:21:{s:6:"active";b:1;s:5:"order";i:3;s:5:"table";s:1:"0";s:6:"column";s:11:"finish_date";s:5:"label";s:11:"Finish date";s:13:"design_length";s:1:"6";s:4:"type";s:8:"datetime";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:4;a:21:{s:6:"active";b:1;s:5:"order";i:4;s:5:"table";s:1:"0";s:6:"column";s:11:"description";s:5:"label";s:11:"Description";s:13:"design_length";i:12;s:4:"type";s:8:"textarea";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:11:"Description";s:6:"length";i:255;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}}',
                "path"=>"Modules/GeneralInformations/Resources/views/livewire/form.blade.php",
            ]);Menu::insert([
                "category" => "simple",
                // "icon" => "",
                "name" => "GeneralInformations",
                "path" => "/generalinformations",
                // "source" => "",
                "item_order" => 7,
                "permission_id" => "Permission::select("id")->where("pseudo_name","view_own_generalinformations_permission")->first()->id",
                "user_id" => 1,
            ]);

        // $this->call("OthersTableSeeder");
    }
}
