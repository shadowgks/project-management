<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UsersController;
use App\Http\Livewire\AppSetting;
use App\Http\Livewire\AppUser;
use App\Http\Livewire\AppRole;
use App\Http\Livewire\ShowRoles;
use App\Http\Livewire\ShowUsers;
use App\Http\Livewire\Module;

use App\Http\Livewire\PdfContent;


use Nwidart\Modules\Facades\Module as TModule;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ChartController;
use App\Http\Livewire\ChartController;
use App\Http\Livewire\Example;
use App\Http\Livewire\GenerateCharts;
use App\Http\Livewire\GenerateFilter;
use App\Http\Livewire\GenerateReport;
use App\Http\Livewire\InvoiceTemplate;
use App\Http\Livewire\ModuleBarcode;
use App\Http\Livewire\ModuleController;
use App\Http\Livewire\ModuleNumbering;
use App\Http\Livewire\ModuleTemplateForm;
use App\Http\Livewire\Project;
use App\Http\Livewire\ProjectView;
use App\Http\Livewire\ReportController;
use App\Http\Livewire\SalesController;
use App\Http\Livewire\ShowPosts;
use App\Http\Livewire\TemplateDemo1;
use App\Http\Livewire\TemplateDemo2;
use App\Http\Livewire\TemplateDemo3;
use App\Http\Livewire\TemplateDemo4;

use App\Http\Controllers\PdfController;
use App\Http\Livewire\Ckeditor;
use App\Http\Livewire\CompanyLivewire;
use App\Http\Livewire\ContactChat;
use App\Http\Livewire\GenerateDropdown;
use App\Http\Livewire\GenerateMenu;
use App\Http\Livewire\GenerateNotification;
use App\Http\Livewire\GroupChat;
use App\Http\Livewire\ModuleList;
use App\Http\Livewire\PDFHeaderAndFooter;
use App\Http\Livewire\PDFTemplate;
use App\Http\Livewire\PrivateChat;
use App\Http\Livewire\TemplateDemo5;
use App\Http\Livewire\UserProfile;

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

// Route::get('/', function () {
//     return redirect('index');
// });

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }

        // Custom page demo for 500 server error
        if (Str::contains($val['path'], 'error-500')) {
            Route::get($val['path'], function () {
                abort(500, 'Something went wrong! Please try again later.');
            });
        }
    }
});

Route::middleware('auth')->group(function () {

    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });
    // Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('settings', AppSetting::class)->name('settings.index');
    Route::get('user/{id}', AppUser::class)->name('user.index');
    Route::get('role/{id}', AppRole::class)->name('role.index');
    Route::get('roles', ShowRoles::class)->name('roles.index');
    Route::get('users', ShowUsers::class)->name('users.index');

    Route::prefix('profile')->group(function () {
        Route::get('{tab}', UserProfile::class)->name('profile.index');
        Route::post('list', [UserProfile::class, 'get_sessions'])->name('profile.logs.list');
    });

    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::prefix('notifications')->group(function () {
        Route::get('get-unread', [GenerateNotification::class, 'getUnreadNotifications'])->name('notifications.get_unread');
        Route::post('set-read', [GenerateNotification::class, 'setRead'])->name('notifications.set_read');
    });

    Route::prefix('companies')->group(function () {
        Route::get('', CompanyLivewire::class);
        Route::post('list', [CompanyLivewire::class, 'generateData'])->name('companies.list');
        Route::post('list/company_sites', [CompanyLivewire::class, 'generateSitesData'])->name('company_sites.list');
        Route::post('list/company_departements', [CompanyLivewire::class, 'generateDepartementsData'])->name('company_departements.list');
    });

    // Module
    Route::prefix('module')->group(function () {
        Route::get('', Module::class);
        Route::prefix('modules')->group(function () {
            Route::get('', ModuleList::class);
            Route::post('list', [ModuleList::class, 'get_list'])->name('modules.list');
        });
        Route::post('change-order', [Module::class, 'changeOrderOfElement'])->name('module.change_order');
        Route::prefix('template-form')->group(function () {
            Route::get('', ModuleTemplateForm::class);
            Route::post('list', [ModuleTemplateForm::class, 'get_settings'])->name('template-form.list');
        });
        Route::prefix('numbering')->group(function () {
            Route::get('', ModuleNumbering::class);
            Route::post('list', [ModuleNumbering::class, 'get_settings'])->name('numbering.list');
        });
        Route::prefix('barcode')->group(function () {
            Route::get('', ModuleBarcode::class);
            Route::post('list', [ModuleBarcode::class, 'get_settings'])->name('barcode.list');
        });
        Route::prefix('lists')->group(function () {
            Route::get('', GenerateReport::class);
            Route::post('list', [GenerateReport::class, 'get_settings'])->name('lists.list');
        });
        Route::prefix('charts')->group(function () {
            Route::get('', GenerateCharts::class);
            Route::post('list', [GenerateCharts::class, 'get_settings'])->name('charts.list');
        });
        Route::prefix('filters')->group(function () {
            Route::get('', GenerateFilter::class);
            Route::post('list', [GenerateFilter::class, 'get_settings'])->name('filters.list');
        });
        Route::prefix('dropdowns')->group(function () {
            Route::get('', GenerateDropdown::class);
            Route::post('list', [GenerateDropdown::class, 'get_settings'])->name('dropdowns.list');
        });
        Route::prefix('notifications')->group(function () {
            Route::get('', GenerateNotification::class);
            Route::post('list', [GenerateNotification::class, 'get_settings'])->name('dropdowns.list');
        });
    });

    Route::get('menu', GenerateMenu::class)->name('module.menu');
    Route::get('examples', Example::class);

    Route::prefix('pdf')->group(function () {
        Route::get('header-footer', PDFHeaderAndFooter::class);
        Route::get('template', PDFTemplate::class);
    });

    Route::prefix('chat')->name('chat')->group(function () {
        Route::get('groups', GroupChat::class);
        Route::get('contacts', ContactChat::class);
        Route::get('get-view', [MessageController::class, 'getMessagesView'])->name('.get-view');
        Route::post('get', [MessageController::class, 'getMessages'])->name('.get');
        Route::post('save', [MessageController::class, 'saveMessage'])->name('.save');
        Route::get('{id?}', PrivateChat::class);
    });

    // Project pages
    Route::get('test', Ckeditor::class);
    Route::get('test-cdn', [Ckeditor::class, 'test_function']);
    // Route::get('posts', ShowPosts::class);
    Route::get('project', Project::class)->name('project.index');
    Route::get('test-report', ReportController::class);
    Route::get('test-chart', ChartController::class);
    Route::get('sales', SalesController::class);
    Route::get('project-view', ProjectView::class);

    Route::prefix('templates')->group(function () {
        Route::get('demo1', TemplateDemo1::class);
        Route::get('demo2', TemplateDemo2::class);
        Route::get('demo3', TemplateDemo3::class);
        Route::get('demo4', TemplateDemo4::class);
        Route::get('demo5', TemplateDemo5::class);
        Route::get('invoice', InvoiceTemplate::class);
        Route::post('list', [TemplateDemo1::class, 'generateData'])->name('example.list');
        Route::post('list_2', [TemplateDemo2::class, 'generateData'])->name('example_2.list');
        Route::post('list_join_files', [TemplateDemo2::class, 'get_join_files'])->name('example_2.join_files');
        Route::post('list_reminders', [TemplateDemo2::class, 'get_reminders'])->name('example_2.reminders');
    });

    // Route::get('pdf', [PdfContent::class, 'render']);
    Route::get('pdf', PdfContent::class);
    Route::post('store-pdf', [PdfContent::class, 'store']);
    Route::get('printData', [PdfContent::class, 'printData']);
});

//Route::resource('users', UsersController::class);

/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);
Route::get('change-lang-to/{lang?}', function ($lang) {
    if (empty($lang)) {
        return [
            'success' => false,
            'message' => 'Language is required',
        ];
    }
    changeLang($lang);

    return [
        'success' => true,
    ];
})->name('settings.change_lang');

require __DIR__ . '/auth.php';

Route::get('generatepdf', [UsersController::class, 'generatepdf'])->name('user.pdf');
Route::get('add-pdf-form', [PdfController::class, 'index']);

//Route::post('store-pdf', [PdfController::class, 'store']);

//Route::get('printData', [PdfController::class, 'printData']);
