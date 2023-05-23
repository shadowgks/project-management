<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class createGateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gate:create';

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
        // $gate_name = $request->gate_name
        $gate_name = 'admin';
        $gate_name_lower_case = strtolower($gate_name);
        $gate_controller = ucfirst($gate_name_lower_case) . 'Controller';

        // New directory in controllers
        Artisan::call('make:controller ' . ucfirst($gate_name_lower_case) . '/' . $gate_controller);

        // New directory in views
        $views_path = resource_path('views/' . $gate_name_lower_case);
        File::makeDirectory($views_path);

        // New directory in routes
        $routes_path = base_path('routes/' . $gate_name_lower_case);
        File::makeDirectory($routes_path);
        $content = "<?php \n use App\Http\Controllers\\" . ucfirst($gate_name_lower_case) . "\\" . $gate_controller . ";        \n
        Route::get(''," . $gate_controller . "::class)->name('" . $gate_name_lower_case . ".index');
        \n ";
        File::put($routes_path . '/' . $gate_name_lower_case . '.php', $content);

        // Add lines in routes gate (Prefix)
        $route_service_provider = base_path('app/Providers/RouteServiceProvider.php');
        $route_configuration_content = "// New prefixes \n Route::middleware('web')
        ->namespace('App\\Http\\Controllers\\" . ucfirst($gate_name_lower_case) . "')
        ->prefix('" . $gate_name_lower_case . "')
        ->as('" . $gate_name_lower_case . ".')
        ->group(base_path('routes/" . $gate_name_lower_case . "/" . $gate_name_lower_case . ".php')); \n";

        file_put_contents($route_service_provider, implode('',
            array_map(function ($data) use ($route_configuration_content) {
                return stristr($data, '// New prefixes') ? $route_configuration_content : $data;
            }, file($route_service_provider))
        ));

        return Command::SUCCESS;
    }
}
