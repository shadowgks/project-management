<?php

namespace App\Http\Livewire;

use App\Helpers\FileHelper;
use App\Helpers\MailHelper;
use App\Mail\TestMail;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Upload;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Traits\AppTrait;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\Orders\Entities\Order;
use Notification;
use OneSignal;
use Spatie\Activitylog\Models\Activity;
use Str;

class Ckeditor extends Component
{
    use AppTrait;
    use WithFileUploads;

    public $files = [];

    public $base_data = [
        'show_upload' => false,
        'file' => [
            'subject_type' => '',
            'file_name' => '',
            'full_name' => '',
            'extension' => '',
        ],
        'user' => null,
    ];

    public function render()
    {
        return view('livewire.ckeditor');
    }

    public function mount()
    {
        // FileHelper::addListenerInProvider('TestListener');
        // FileHelper::addEventInProvider('TestEvent', 'TestListener');
        // FileHelper::addModuleEventInProvider('Tests', 'TestEvent', 'TestListener');
        // User::changeLang('fr');
        // User::changeLang('en');
        // dd(app()->getLocale());
        // dd(Str::startsWith('mails.form', 'mails'));
        // dd(Menu::getLastOrder());
        // dd(Permission::getPermissionByPseudo('view_collectifaccountsgroups_permission', 'id'));

        // $fields['include_player_ids'] = ['xxxxxxxx-xxxx-xxx-xxxx-yyyyyyyyy'];
        // $message = 'hey!! this is test push.!';

        // OneSignal::sendPush($fields, $message);
        $file = Upload::find(1);
        if ($file != null) {
            $this->base_data['file'] = [
                'subject_type' => $file->subject_type,
                'subject_id' => $file->subject_id,
                'subject_name' => class_basename($file->subject_type),
                'file_name' => $file->file_name,
                'full_name' => $file->full_name,
                'extension' => $file->extension,
            ];
        }
        $this->base_data['user'] = User::find(1);
    }

    public function updatedFiles()
    {
        // You can do whatever you want to do with $this->files here
    }

    public function test_function()
    {
        // $user = Auth::user();
        // $new_content = '
        //     <div>
        //         <p>This is changed content</p>
        //     </div>
        // ';
        // FileHelper::replaceOneLineFileContent('tests/Test-file.php', '$value = "This is test";\n', '// test-comment');
        // FileHelper::replaceMultipleLinesFileContent('tests/Test-file.php', '$value = "This is test";\n', '// test-comment-start', '// test-comment-end');
        // FileHelper::replaceMultipleLinesFileContent('tests/Views/test-file.blade.php', $new_content, '{{-- preview_form_start --}}', '{{-- preview_form_end --}}');

        // activity()->performedOn(new Order)->log('Look, I logged something');
        // activity()->causedBy($user)
        //     ->performedOn(Order::all()->last())
        //     ->withProperties(['key' => 'value'])
        //     ->log('showed');
        // echo "<h2>Done</h2>";

        // dd(Activity::all()->last());
        return view('test');
    }

    public function send_notification()
    {
        $this->req(function () {
            $users = [1, 2, 3];
            // Notification::send(User::whereIn('id', $users)->get(), new TestNotification());
            Auth::user()->notify(new TestNotification(User::whereIn('id', $users)->get()));
            $this->showSlideAlert('success', 'Notification sent successfully!');

            // $notif_id = 'e52bc33e-a6ae-4619-8a60-cc9aacd9fadc';
            // Auth::user()->unreadNotifications->when($notif_id, function ($query) use ($notif_id) {
            //     return $query->where('id', $notif_id);
            // })->markAsRead();
            // $this->showSlideAlert('success', 'Notification mark as read successfully!');
        });
    }

    public function send_email()
    {
        $this->req(function () {
            MailHelper::sendMail('Hey test_name 😉, Just for test.', 'testreceiver@gmail.com');
            // MailHelper::sendMailView('test', 'testreceiver@gmail.com', null, [
            //     'name' => 'test_name'
            // ]);

            $this->showSlideAlert('success', 'Mail sent successfully!');
        });
    }

    public function show_upload($bool)
    {
        $this->base_data['show_upload'] = $bool;
    }

    public function save_file()
    {
        // dd($this->files);
        upload_files($this->files, User::find(1));
    }
}
