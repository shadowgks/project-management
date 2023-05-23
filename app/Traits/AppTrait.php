<?php

namespace App\Traits;

use App\Helpers\StringHelper;
use App\Models\Comment;
use App\Models\Reminder;
use App\Models\Upload;
use Arr;
use Auth;
use DataTables;
use DB;
use Exception;
use Illuminate\Http\Request;
use Str;

trait AppTrait
{
    public $time;
    public $supportData = [];

    public $appOptions = [
        'id' => null,
        'subject' => [
            'type' => null,
            'name' => null,
        ],
        'app_module_id' => null,
        'helper' => [],
        'visible' => false,
        'alert' => [
            'show' => false,
            'type' => '',
            'target' => '',
            'content' => '',
            'button' => '',
        ],
        'modal' => [
            'show' => false,
            'current' => null,
        ],
    ];

    public $appValues = [
        "reminders" => [
            'id' => null,
            "date" => "",
            "by_email" => false,
            "user" => "",
            "value" => "",
            'datatable' => [
                'name' => 'reminders',
                'columns' => ['from', 'to', 'description', 'date_reminde', 'by_mail', 'actions'],
            ]
        ],
        "upload_file" => [
            'id' => 'join-files',
            'datatable' => [
                'name' => 'join_files',
                'columns' => ['full_name', 'file_size', 'visibility', 'created_at', 'actions'],
            ],
        ],
        "comments" => [
            'id' => null,
            "value" => "",
            "rows" => [],
        ],
    ];

    public $loading = [
        'show' => false,
    ];

    public function loadingVisible($bool)
    {
        if (!in_array($bool, [true, false]))
            throw new \Exception("loadingVisible parametre must be true or false");

        $this->loading['show'] = $bool;
        $this->dispatchBrowserEvent('loadingVisible', $bool);
    }

    public function showSlideAlert($type, $content, $title = null)
    {
        $type = Str::lower($type);

        if (!in_array($type, ['success', 'warning', 'error']))
            throw new \Exception($type . " is not allowed!");

        $data = [
            'type' => $type,
            'content' => $content,
        ];

        if ($title != null)
            $data['title'] = $title;

        $this->dispatchBrowserEvent('showSlideAlert', $data);
    }

    public function req($callback, $options = [])
    {
        $type = gettype($callback);
        $db_exception = (!isset($options['db_exception']) || $options['db_exception'] == true);
        $hide_alert = (isset($options['hide_alert']) && $options['hide_alert'] == true);

        if ($type == 'object') {
            try {
                if ($db_exception)
                    DB::beginTransaction();

                $callback();

                if ($db_exception)
                    DB::commit();

                if ($hide_alert)
                    $this->hideAlert();

                $this->loadingVisible(false);
            } catch (Exception $e) {
                if ($db_exception)
                    DB::rollBack();

                $this->showSlideAlert('error', getErrorMessage($e), 'Error');
                $this->loadingVisible(false);
            }
        } else
            throw new Exception("Parametre must be function!");
    }

    public function changeVisibility($bool)
    {
        if (!in_array($bool, [true, false]))
            throw new \Exception("changeVisibility parametre must be true or false");

        $this->appOptions['visible'] = $bool;
    }

    public function changeValue($data)
    {
        $model = StringHelper::getModelVariable($data['key']);

        switch ($model['parent']) {
            case 'filters':
                Arr::set($this->filters, $model['model'], $data['value']);
                break;

            case 'form':
                Arr::set($this->form, $model['model'], $data['value']);
                break;

            default:
                throw new \Exception($model['parent'] . ' is not a variable');
                break;
        }
    }

    public function joinFiles()
    {
        upload_files($this->appValues['upload_file']['files'], $this->appOptions['subject'], [
            'properties' => [
                'row_id' => $this->appOptions['id'],
            ],
            'app_module_id' => $this->appOptions['app_module_id'],
        ]);

        $this->app_cancel_option();
        $this->appValues['upload_file']['files'] = [];
        $this->dispatchBrowserEvent('reloadJoinFile', $this->appValues['upload_file']['id']);
        $this->reloadTable($this->base_data['module_name']);
        $this->showSlideAlert('success', __('Files uploaded with success.'), __('Join Files'));
    }

    public function getJoinFiles(Request $request)
    {
        $data = Upload::where('app_module_id', $request->app_module_id)->where('user_id', Auth::id());
        $data = DataTables::of($data)->addIndexColumn();

        $data = $data->addColumn('visibility', function ($row) {
            return '
                <label
                    class="form-check form-switch form-check-custom form-check-solid mb-3">
                    <input class="form-check-input" type="checkbox" ' . ($row['visible'] ? 'checked' : '') . '>
                    <span class="form-check-label fw-semibold text-muted"></span>
                </label>
            ';
        });

        $data = $data->addColumn('created_at', function ($row) {
            return _dt($row['created_at']);
        });

        $data = $data->addColumn('actions', function ($row) {
            $btn = '
                <p class=\"text-end mb-0\">
                    <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                        <i class="fa fa-download p-0"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                        <i class="fa fa-trash p-0"></i>
                    </button>
                </p>
            ';
            return $btn;
        });

        $data = $data->rawColumns(["checkbox", "barcode", "reference", "visibility", "created_by", "flagged", "actions"])->make(true);
        return $data;
    }

    public function saveComment()
    {
        Comment::_save([
            'rel_id' => $this->appOptions['id'],
            'app_module_id' => $this->appOptions['app_module_id'],
            'description' => $this->appValues['comments']['value'],
        ], $this->appValues['comments']['id']);

        $this->app_cancel_option();
    }

    public function editComment($id)
    {
        $comment = Comment::_get($id);
        $this->appValues['comments']['id'] = $id;
        $this->appValues['comments']['value'] = $comment->description;
        $this->appOptions['modal']['current'] = 'comments';
        $this->app_action_modal();
    }

    public function deleteComment($id)
    {
        Comment::_delete($id);
        $this->showSlideAlert('success', 'Comment deleted successfully');
    }

    public function saveReminder()
    {
        Reminder::_save([
            'rel_id' => $this->appOptions['id'],
            'app_module_id' => $this->appOptions['app_module_id'],
            'description' => $this->appValues['reminders']['value'],
            'date' => $this->appValues['reminders']['date'],
            'user_to_notify' => $this->appValues['reminders']['user'],
            'notify_by_mail' => $this->appValues['reminders']['by_email'],
        ], $this->appValues['reminders']['id']);

        $this->app_cancel_option();
        $this->showSlideAlert('success', 'Reminder added successfully');
        $this->reloadTable($this->base_data['module_name'] . '-' . $this->appValues['reminders']['datatable']['name']);
    }

    public function editReminder($id)
    {
        $reminder = Reminder::_get($id);
        $this->appValues['reminders']['id'] = $id;
        $this->appValues['reminders']['value'] = $reminder->description;
        $this->appValues['reminders']['date'] = $reminder->date;
        $this->appValues['reminders']['user'] = $reminder->user_to_notify;
        $this->appValues['reminders']['by_email'] = $reminder->notify_by_mail;
        $this->appOptions['modal']['current'] = 'reminders';
        $this->app_action_modal();
    }

    public function deleteReminder($id)
    {
        Reminder::_delete($id);
        $this->showSlideAlert('success', 'Reminder deleted successfully');
        $this->reloadTable($this->base_data['module_name'] . '-' . $this->appValues['reminders']['datatable']['name']);
    }

    public function getReminders(Request $request)
    {
        $data = Reminder::where('app_module_id', $request->app_module_id)->where('user_id', Auth::id())->with('created_by', 'user_to');
        $data = DataTables::of($data)->addIndexColumn();

        $data = $data->addColumn('from', function ($row) {
            return '
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a
                            href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                            <div class="symbol-label">
                                <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-6.jpg"
                                    alt="Emma Smith" class="w-100">
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                            class="text-gray-800 text-hover-primary mb-1">' . ($row['created_by'] == null ? '-' : $row['created_by']['first_name'] . ' ' . $row['created_by']['last_name']) . '</a>
                    </div>
                </div>
            ';
        });

        $data = $data->addColumn('to', function ($row) {
            return '
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a
                            href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                            <div class="symbol-label">
                                <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-6.jpg"
                                    alt="Emma Smith" class="w-100">
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                            class="text-gray-800 text-hover-primary mb-1">' . ($row['user_to'] == null ? '-' : $row['user_to']['first_name'] . ' ' . $row['user_to']['last_name']) . '</a>
                    </div>
                </div>
            ';
        });

        $data = $data->addColumn('date_reminde', function ($row) {
            return _dt($row['date']);
        });

        $data = $data->addColumn('by_mail', function ($row) {
            return '
                <label
                    class="form-check form-switch form-check-custom form-check-solid mb-3">
                    <input class="form-check-input" type="checkbox" ' . ($row['notify_by_mail'] ? 'checked' : '') . '>
                    <span class="form-check-label fw-semibold text-muted"></span>
                </label>
            ';
        });

        $data = $data->addColumn('created_at', function ($row) {
            return _dt($row['created_at']);
        });

        $data = $data->addColumn('actions', function ($row) {
            $btn = '
                <p class=\"text-end mb-0\">
                    <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1" onclick="liveCall(\'editReminder\', ' . $row['id'] . ')" wire:click="editReminder(' . $row['id'] . ')">
                        <i class="fa fa-pencil p-0"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-shadow btn-icon" onclick="liveCall(\'deleteReminder\', ' . $row['id'] . ')" wire:click="deleteReminder(' . $row['id'] . ')">
                        <i class="fa fa-trash p-0"></i>
                    </button>
                </p>
            ';
            return $btn;
        });

        $data = $data->rawColumns(["from", "to", "date_reminde", "created_by", "by_mail", "actions"])->make(true);
        return $data;
    }

    public function app_action_modal()
    {
        $this->req(function () {
            $this->appOptions["modal"]["show"] = !$this->appOptions["modal"]["show"];
        });
    }

    public function app_click_option($option)
    {
        $this->req(function () use ($option) {
            $this->appOptions["modal"]["title"] = $option;
            $this->appOptions["modal"]["current"] = $option;
            $this->action_options("show_dropdown");
            $this->app_action_modal();
        });
    }

    public function app_cancel_option()
    {
        $this->req(function () {
            if ($this->appOptions["modal"]["current"] == "reminders") {
                $this->appValues["reminders"]["date"] = "";
                $this->appValues["reminders"]["by_email"] = false;
                $this->appValues["reminders"]["user"] = "";
                $this->appValues["reminders"]["value"] = "";
                $this->appValues['reminders']['id'] = null;
            } else if ($this->appOptions["modal"]["current"] == "upload_file") {
                $this->appValues["upload_file"]["file"] = null;
            } else if ($this->appOptions["modal"]["current"] == "comments") {
                $this->appValues["comments"]["value"] = "";
                $this->appValues['comments']['id'] = null;
            }

            $this->app_action_modal();
        });
    }

    public function reloadTable($id, $dataArray = [])
    {
        $data = array_merge([
            'id' => $id,
        ], $dataArray);

        $this->dispatchBrowserEvent('reloadTable', $data);
    }

    public function _clear($data, $exceptions = [])
    {
        $new_array = [];
        $count_exceptions = count($exceptions);

        foreach ($data as $key => $dt) {
            $type = gettype($dt);

            if ($count_exceptions > 0 && array_key_exists($key, $exceptions)) {
                $new_array[$key] = $exceptions[$key];
            } else {
                if ($type == 'array') {
                    $new_array[$key] = [];
                } else if ($type == 'boolean') {
                    $new_array[$key] = false;
                } else if ($type == 'string') {
                    $new_array[$key] = '';
                } else if (in_array($type, ['integer', 'float', 'double', 'decimal'])) {
                    $new_array[$key] = 0;
                } else {
                    $new_array[$key] = null;
                }
            }
        }

        return $new_array;
    }

    private function showAlert($type, $content, $target = null, $buttonContent = null)
    {
        $this->appOptions['alert']['show'] = true;
        $this->appOptions['alert']['type'] = $type;
        $this->appOptions['alert']['content'] = $content;

        if ($target == null) {
            $this->appOptions['alert']['target'] = '';
        } else {
            $this->appOptions['alert']['target'] = $target;
        }

        if ($buttonContent == null) {
            $this->appOptions['alert']['button'] = '';
        } else {
            $this->appOptions['alert']['button'] = $buttonContent;
        }

        $this->dispatchBrowserEvent('showAlert', $this->appOptions['alert']);
    }

    private function hideAlert()
    {
        $this->appOptions['alert']['show'] = false;
        $this->appOptions['alert']['type'] = '';
        $this->appOptions['alert']['content'] = '';
        $this->appOptions['alert']['target'] = '';
        $this->appOptions['alert']['button'] = '';
        $this->dispatchBrowserEvent('hideAlert');
    }
}
