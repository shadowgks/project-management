<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('generalinformations')->middleware('auth')->group(function() {

                Route::get("", GeneralInformations::class);
                Route::post("list", "GeneralInformations@generateData")->name("generalinformations.list");
            Route::post("list_join_files", "GeneralInformations@getJoinFiles")->name("generalinformations.join_files");Route::post("list_reminders", "GeneralInformations@getReminders")->name("generalinformations.reminders");});
