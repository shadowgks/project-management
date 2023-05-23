<?php

namespace App\Console\Commands;

use App\Models\AppModule;
use App\Models\Permission;
use Auth;
use Illuminate\Console\Command;

class GenerateEmailPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:generate email {module_name} {template_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $template_name = $this->argument('template_name');
        $module = AppModule::where('pseudo_name', $this->argument('module_name'))->first();
        $data['app_module_id'] = $module->id;
        $data['user_id'] = Auth::user()->id;
        $data['category'] = "send_email";
        $data['pseudo_name'] = "send_" . $template_name . "_permission";
        Permission::insert($data);
        $data['category'] = "receive_email";
        $data['pseudo_name'] = "receive_" . $template_name . "_permission";
        Permission::insert($data);
        return Command::SUCCESS;
    }
}
