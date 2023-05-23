<?php

namespace Modules\Tasks\Database\Seeders;


            use Illuminate\Database\Seeder;
            use App\Models\AppModule;
            use Illuminate\Support\Facades\Artisan;
            use Illuminate\Support\Facades\DB;
            
                use App\Models\Validation;
                use App\Models\Permission;
                use App\Models\Status;use App\Models\Permission;use App\Models\ValidationStep;use App\Models\DropDown;use App\Models\Form;use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;

class TasksDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            AppModule::create([
                "name" => "Tasks",
            "pseudo_name" => "tasks",
            "description" => "",
            "empty_when_reinitializating" => 1,
            "emailing" => 0,
            "notifications" => 0,
            "pdf" => 0,
            "contain_validator" => 1,
            "activate_importation" => 0,
            "activate_file_upload" => 1,
            "activate_comments" => 1,
            "activate_reminders" => 1,
            "activate_duplicate" => 1,
            "namespace" => "Modules\Tasks\Entities",
            "gate_id" => 1,
            "user_id" => 1,
            "app_id" => 1,
            "active" => 1,
            ]);
            $app_module_id = AppModule::where("pseudo_name","tasks")->first()->id;
            Validation::insert([
                "name"=>task_validation,
                "require_order"=>1,
                "user_id"=>1,
                "app_module_id"=> $app_module_id]);
                
                        Status::insert([
                    "name"=>not started,
                    "color"=>secondary
                        Permission::insert([
                    "pseudo_name"=>"Not started_Task_validation_permission",
                    "category"=> "validation",
                    "user_id"=>1,
                    "app_module_id"=>$app_module_id]);
                    
                        ValidationStep::insert([
                    "name"=>Not started,
                    "status_id"=>1,
                    "step_order"=>0,
                    "validation_id"=>3,
                    "user_id"=>1,]);
                    
                        Status::insert([
                    "name"=>in progress,
                    "color"=>primary
                        Permission::insert([
                    "pseudo_name"=>"In progress_Task_validation_permission",
                    "category"=> "validation",
                    "user_id"=>1,
                    "app_module_id"=>$app_module_id]);
                    
                        ValidationStep::insert([
                    "name"=>In progress,
                    "status_id"=>2,
                    "step_order"=>1,
                    "validation_id"=>3,
                    "user_id"=>1,]);
                    
                        Status::insert([
                    "name"=>waiting for feedback,
                    "color"=>info
                        Permission::insert([
                    "pseudo_name"=>"Waiting for feedback_Task_validation_permission",
                    "category"=> "validation",
                    "user_id"=>1,
                    "app_module_id"=>$app_module_id]);
                    
                        ValidationStep::insert([
                    "name"=>Waiting for feedback,
                    "status_id"=>3,
                    "step_order"=>2,
                    "validation_id"=>3,
                    "user_id"=>1,]);
                    
                        Status::insert([
                    "name"=>complete,
                    "color"=>success
                        Permission::insert([
                    "pseudo_name"=>"Complete_Task_validation_permission",
                    "category"=> "validation",
                    "user_id"=>1,
                    "app_module_id"=>$app_module_id]);
                    
                        ValidationStep::insert([
                    "name"=>Complete,
                    "status_id"=>4,
                    "step_order"=>3,
                    "validation_id"=>3,
                    "user_id"=>1,]);
                    
                        Status::insert([
                    "name"=>cancelled,
                    "color"=>danger
                        Permission::insert([
                    "pseudo_name"=>"Cancelled_Task_validation_permission",
                    "category"=> "validation",
                    "user_id"=>1,
                    "app_module_id"=>$app_module_id]);
                    
                        ValidationStep::insert([
                    "name"=>Cancelled,
                    "status_id"=>5,
                    "step_order"=>4,
                    "validation_id"=>3,
                    "user_id"=>1,]);
                    
                Artisan::call('permission:create tasks basic');Form::insert([
                "name"=>"Tasks_basic_form",
                "app_module_id"=>$app_module_id,
                "user_id"=>1,
                "value"=>'a:5:{i:0;a:21:{s:6:"active";b:1;s:5:"order";i:0;s:5:"table";s:1:"0";s:6:"column";s:5:"title";s:5:"label";s:5:"Title";s:13:"design_length";s:1:"6";s:4:"type";s:4:"text";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:5:"Title";s:6:"length";i:255;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:1;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:0;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:1;a:21:{s:6:"active";b:1;s:5:"order";i:1;s:5:"table";s:1:"0";s:6:"column";s:10:"start_date";s:5:"label";s:10:"Start date";s:13:"design_length";s:1:"6";s:4:"type";s:8:"datetime";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:2;a:21:{s:6:"active";b:1;s:5:"order";i:2;s:5:"table";s:1:"0";s:6:"column";s:8:"end_date";s:5:"label";s:8:"End date";s:13:"design_length";s:1:"6";s:4:"type";s:8:"datetime";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:3;a:21:{s:6:"active";b:1;s:5:"order";i:3;s:5:"table";s:1:"0";s:6:"column";s:11:"priority_id";s:5:"label";s:11:"Priority id";s:13:"design_length";s:1:"6";s:4:"type";s:6:"select";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:10:"drop_downs";s:6:"column";s:12:"select_value";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:0:"";s:6:"length";i:0;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:1;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:0;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}i:4;a:21:{s:6:"active";b:1;s:5:"order";i:4;s:5:"table";s:1:"0";s:6:"column";s:11:"description";s:5:"label";s:11:"Description";s:13:"design_length";i:12;s:4:"type";s:8:"textarea";s:5:"value";a:4:{s:4:"type";s:4:"data";s:5:"table";s:0:"";s:6:"column";s:0:"";s:6:"custom";a:0:{}}s:7:"default";s:0:"";s:11:"placeholder";s:11:"Description";s:6:"length";i:255;s:3:"min";i:0;s:3:"max";i:0;s:14:"previous_dates";b:1;s:10:"next_dates";b:1;s:8:"required";b:0;s:6:"unique";b:0;s:9:"use_regex";b:0;s:11:"regex_value";s:0:"";s:7:"options";a:3:{s:13:"show_required";b:1;s:11:"show_unique";b:1;s:7:"popover";a:2:{s:3:"use";b:0;s:7:"content";s:0:"";}}s:6:"errors";a:4:{s:5:"table";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:6:"column";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:5:"label";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}s:4:"type";a:2:{s:4:"show";b:0;s:7:"message";s:0:"";}}}}',
                "path"=>"Modules/Tasks/Resources/views/livewire/form.blade.php",
            ]);Menu::insert([
                "category" => "simple",
                // "icon" => "",
                "name" => "Tasks",
                "path" => "/tasks",
                // "source" => "",
                "item_order" => 8,
                "permission_id" => "Permission::select("id")->where("pseudo_name","view_own_tasks_permission")->first()->id",
                "user_id" => 1,
            ]);

        // $this->call("OthersTableSeeder");
    }
}
