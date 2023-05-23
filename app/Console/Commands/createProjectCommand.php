<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDO;

class createProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
/*
$request->project_name
$request->project_description
$request->project_saas
$request->project_template
$request->db_name
$request->include_tables
 */
        // Copy project depending on the template choosed

        $project_app_name = str_replace(' ', '_', strtolower('Project test'));
        if (is_dir(storage_path('app/algobridge/projects/' . $project_app_name)) === false) {
            Storage::makeDirectory('algobridge/projects/' . $project_app_name);
        }
        $src = storage_path('app/algobridge/project_templates/laravel_demo');
        $dst = storage_path('app/algobridge/projects/' . $project_app_name);
        File::copyDirectory($src, $dst);

        // Create database

        // DB::getConnection()->statement('CREATE DATABASE :schema', array('schema' => $project_app_name));

        try {
            $dbname = $project_app_name;
            $connection = $this->hasArgument('connection') && $this->argument('connection') ? $this->argument('connection') : DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

            $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . "'" . $dbname . "'");

            if (empty($hasDb)) {
                DB::connection($connection)->select('CREATE DATABASE ' . $dbname);
                $this->info("Database '$dbname' created for '$connection' connection");
            } else {
                $this->info("Database $dbname already exists for $connection connection");
            }
        } catch (\Exception$e) {
            $this->error($e->getMessage());
        }

        // Update .env file

        $db_line = 13;
        $filepath = storage_path('app/algobridge/projects/' . $project_app_name . '/.env');
        $txt = file($filepath);
        $content = file_get_contents($filepath);
        $update = "DB_DATABASE=" . $project_app_name . "\n";
        // Make the change to line in array
        $txt[$db_line] = $update;

        // Replace initial string (from $txt array) with $update in $content
        $newcontent = str_replace($txt[$db_line], $update, $content);
        file_put_contents($filepath, $newcontent);
        // Put the lines back together, and write back into txt file file_put_contents($filepath, implode("", $txt));

        // Insert data related to project in db

    }
}
