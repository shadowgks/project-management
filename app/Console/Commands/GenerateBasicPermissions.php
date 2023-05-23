<?php

namespace App\Console\Commands;

use App\Models\AppModule;
use App\Models\Permission;
use Auth;
use Illuminate\Console\Command;

class GenerateBasicPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create {module_name} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new permission';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->argument('type');
        $module_pseudo_name = trim($this->argument('module_name'));
        $module = AppModule::where('pseudo_name', $module_pseudo_name)->first();
        $data['category'] = "module";
        $data['user_id'] = Auth::user()->id;
        $data['app_module_id'] = $module->id;
        $permissions = available_permissions($module_pseudo_name, $type);
        foreach ($permissions as $permission) {
            $data['pseudo_name'] = $permission;
            Permission::insert($data);
        }
        return Command::SUCCESS;
    }
}
