<?php

namespace App\Console\Commands;

use App\Models\AppModule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class saveModuleDataInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:save_in_db {name} {description} {empty_when_reinatialization} {contain_validation} {emailing} {notifications} {pdf} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save module basic informations in database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data['name'] = $this->argument('name');
        $data['description'] = $this->argument('description');
        $data['empty_when_reinatialization'] = $this->argument('empty_when_reinatialization');
        $data['contain_validation'] = $this->argument('contain_validation');
        $data['emailing'] = $this->argument('emailing');
        $data['notifications'] = $this->argument('notifications');
        $data['pdf'] = $this->argument('pdf');
        $data['pseudo_name'] = str_replace(array('[', ']', ' ', '"', '"'), '', strtolower($data['name']));
        $data['created_by'] = Auth::id() != null ? Auth::id() : 1;
        AppModule::insert($data);

        return Command::SUCCESS;
    }
}
