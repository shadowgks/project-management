<?php

namespace App\Traits\Module;

use App\Helpers\ModelHelper;
use App\Models\AppModule;
use App\Models\DropDown;
use App\Traits\AppTrait;

trait DropdownTrait
{
    use AppTrait;

    public $dropdown_trait = [
        'base_data' => [
            'modules' => [],
            'tables' => [],
            'columns' => [],
            'datatable' => [
                'name' => 'dropdowns',
                'columns' => ['app_module.name', 'date', 'actions'],
                'route' => 'dropdowns.list',
            ],
        ],
        'values' => [
            'module' => '',
            'table' => '',
            'column' => '',
            'fields' => [],
        ],
        'options' => [],
    ];

    public function dropdown_getSupportedData()
    {
        $this->dropdown_trait['base_data']['modules'] = AppModule::_get();
        $this->dropdown_trait['base_data']['tables'] = ModelHelper::getTables();
    }

    public function dropdown_get_columns()
    {
        $this->req(function () {
            $this->dropdown_trait['base_data']['columns'] = ModelHelper::getColumnsOfTable($this->dropdown_trait['values']['table']);
        });
    }

    public function dropdown_addOption($data = null)
    {
        $this->req(function () use ($data) {
            array_push($this->dropdown_trait['values']['fields'], [
                'id' => ($data == null ? '' : $data['select_id']),
                'value' => ($data == null ? '' : $data['select_value']),
                'new' => $data == null,
                'saved_id' => ($data == null ? '' : $data['id']),
            ]);
        });
    }

    public function dropdown_removeOption($optionKey)
    {
        $this->req(function () use ($optionKey) {
            $arrayHelper = [];

            foreach ($this->dropdown_trait['values']['fields'] as $key => $customField) {
                if ($key != $optionKey) {
                    array_push($arrayHelper, $customField);
                }
            }

            $this->dropdown_trait['values']['fields'] = $arrayHelper;
        });
    }

    public function dropdown_save()
    {
        $this->req(function () {
            foreach ($this->dropdown_trait['values']['fields'] as $dropdown) {
                Dropdown::_save([
                    'select_table' => $this->dropdown_trait['values']['table'],
                    'select_field' => $this->dropdown_trait['values']['column'],
                    'select_id' => $dropdown['id'],
                    'select_value' => $dropdown['value'],
                    'app_module_id' => $this->dropdown_trait['values']['module'],
                ], ($dropdown['saved_id'] == '' ? null : $dropdown['saved_id']));
            }

            $this->deleteRemovedFields();
            $this->dropdown_cancel();
            $this->reloadTable($this->base_data['datatable']['name']);
            $this->showSlideAlert('success', 'Dropdown created successfully!');
        });
    }

    public function setSavedId($data)
    {
        foreach ($data['saved_options'] as $key => $option) {
            $this->dropdown_trait['values']['fields'][$key]['saved_id'] = $option;
        }
    }

    public function dropdown_edit_settings($data)
    {
        $this->req(function () use ($data) {
            $select_field = $data['select_field'];
            $app_module_id = $data['app_module_id'];
            $dropdowns = Dropdown::_edit_get($select_field, $app_module_id)->toArray();

            $this->dropdown_trait['values']['table'] = $dropdowns[0]['select_table'];
            $this->dropdown_trait['values']['module'] = $app_module_id;
            $this->dropdown_trait['values']['column'] = $select_field;
            foreach ($dropdowns as $dropdown) {
                $this->dropdown_addOption($dropdown);
            }

            $this->dropdown_get_columns();
            $this->changeVisibility(true);
        });
    }

    public function dropdown_delete_settings($data)
    {
        $this->req(
            function () use ($data) {
                $this->appOptions['helper'] = $data;
                $this->showAlert("question", "Are you sure?", "delete");
            }
        );
    }

    public function dropdown_cancel()
    {
        $this->req(function () {
            $this->dropdown_trait['base_data']['columns'] = [];

            $this->dropdown_trait['values'] = [
                'module' => '',
                'table' => '',
                'column' => '',
                'fields' => [],
            ];

            $this->appOptions['id'] = null;
            $this->changeVisibility(false);
        });
    }

    private function deleteRemovedFields()
    {
        $saved_dropdowns = Dropdown::_edit_get($this->dropdown_trait['values']['column'], $this->dropdown_trait['values']['module']);
        foreach ($saved_dropdowns as $dropdown) {
            $exist = false;
            foreach ($this->dropdown_trait['values']['fields'] as $field) {
                if ($field['new'] || $dropdown['id'] == $field['saved_id']) {
                    $exist = true;
                }
            }

            if (!$exist) {
                DropDown::_delete($dropdown['id']);
            }
        }
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            if ($this->appOptions["alert"]["target"] == "delete") {
                if ($result) {
                    Dropdown::_delete_dropdowns($this->appOptions['helper']['select_field'], $this->appOptions['helper']['app_module_id']);
                    $this->reloadTable($this->base_data['datatable']['name']);
                }

                $this->appOptions['helper'] = [];
            }
        }, [
            'hide_alert' => true,
        ]);
    }
}
