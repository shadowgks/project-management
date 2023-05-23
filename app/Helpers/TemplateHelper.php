<?php

namespace App\Helpers;

use Carbon\Carbon;
use Str;

class TemplateHelper
{
    public static function getFormElement($element, $options = [])
    {
        $elementLength = isset($element['design_length']) ? $element['design_length'] : 12;
        $model = (isset($options['key']) && !empty($options['key']) ? 'form.' . $options['key'] . '.' . $element['column'] : 'form.' . $element['column']);

        $result = '';
        if (in_array($element['type'], ['checkbox', 'radio', 'select', 'multiple_select'])) {
            if ($element['type'] == 'select' || $element['type'] == 'multiple_select') {
                $result .= '
                <div class="fv-row mb-10 col-md-' . $elementLength . ' fv-plugins-icon-container" wire:ignore>
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span' . (isset($element['required']) && $element['required'] ? ' class="required"' : '') . '>{{ __("' . (__($element['label']) ?? '') . '") }}</span>
                    </label>
                    <select
                        class="form-select select-2-dropdown @error("title") is-invalid @enderror"
                        name="' . ($element['column'] ?? '') . '"
                        wire:model="' . $model . '"
                        ' . ($element['type'] == 'multiple_select' ? 'multiple' : '') . '
                    >
                        <option value="" disabled>{{ __("Choose") }}</option>
                ';
            }

            if (in_array($element['type'], ['checkbox', 'radio'])) {
                $result .= '<div class="fv-row row mb-5 mx-0 col-md-12">' . PHP_EOL . '<label class="d-flex align-items-center fs-5 fw-semibold mb-2 px-0">
                    <span' . (isset($element['required']) && $element['required'] ? ' class="required"' : '') . '>{{ __("' . (__($element['label']) ?? '') . '") }}</span>
                </label>';
            }

            $result .= '@foreach($base_data["' . ($element['column'] . '_options') . '"] as $dt)';
            if ($element['type'] == 'checkbox') {
                $result .= renderCheckbox('field-' . $element['column'] . '-{{ $dt["id"] }}', $model, '$dt["text"]', [
                    'class' => 'col-md-' . $elementLength,
                    'name' => 'field-' . $element['column'],
                    'value' => '{{ $dt["id"] }}',
                    'labelVariable' => true,
                    'renderInFile' => true,
                ]);
            } else if ($element['type'] == 'radio') {
                $result .= renderRadio('field-' . $element['column'] . '-{{ $dt["id"] }}', $model, '$dt["text"]', [
                    'class' => 'col-md-' . $elementLength,
                    'name' => 'field-' . $element['column'],
                    'value' => '{{ $dt["id"] }}',
                    'labelVariable' => true,
                    'renderInFile' => true,
                ]);
            } else {
                $result .= '<option value="{{ $dt["id"] }}">{{ $dt["text"] }}</option>';
            }
            $result .= '@endforeach' . PHP_EOL;

            if (in_array($element['type'], ['checkbox', 'radio'])) {
                $result .= '</div>';
            }

            if ($element['type'] == 'select') {
                $result .= '
                   </select>
                </div>';
            }
        } else if ($element['type'] == 'switch') {
            $result = renderSwitch('field-' . $element['column'], 'form.' . ($element['column'] ?? ''), (__($element['label']) ?? ''), [
                'name' => ($element['column'] ?? ''),
                'class' => 'col-md-' . $elementLength,
                'renderInFile' => true,
            ]);
        } else if ($element['type'] == 'file') {
            $result = '<div class="fv-row mb-5 d-flex flex-row align-items-center col-md-' . $elementLength . '">
                <livewire:input-file class="col-md-' . $elementLength . '" :button="true" _id="field-' . $element['column'] . '" model="' . $model . '" />
            </div>';
        } else {
            if ($element['type'] == 'textarea') {
                $result = renderTextarea('field-' . $element['column'], $model, $element['label'], [
                    'class' => 'col-md-' . $elementLength,
                    'required' => isset($element['required']) && $element['required'],
                    'name' => 'field-' . $element['column'],
                    'renderInFile' => true,
                ]);
            } else {
                $options = [
                    'type' => $element['type'],
                    'class' => 'col-md-' . $elementLength,
                    'required' => isset($element['required']) && $element['required'],
                    'name' => 'field-' . $element['column'],
                    'renderInFile' => true,
                ];

                if (isset($element['length']) && $element['type'] == 'text') {
                    $options['maxlength'] = ($element['length'] == 0 ? '' : ((int) $element['length'] ?? 1));
                }

                if (isset($element['min']) && $element['type'] == 'number') {
                    $options['min'] = ((int) $element['min'] ?? 0);
                }

                if (isset($element['max']) && $element['type'] == 'number') {
                    $options['max'] = ((int) $element['max'] ?? 1);
                }

                $result = renderInput('field-' . $element['column'], $model, $element['label'], $options);
            }
        }

        return $result;
    }

    public static function getDateFormat($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public static function formatNumber($number, $after = 2)
    {
        return number_format((float) $number, $after, '.', '');
    }

    public static function formatPrice($number, $after = 2)
    {
        return number_format((float) $number, $after, '.', '') . 'DH';
    }

    public static function checkDueDate($date, $days = 7)
    {
        $now = Carbon::now();
        $checkDate = Carbon::parse($date);
        $dueDays = $checkDate->diffInDays($now);

        return [
            'show' => $dueDays >= $days,
            'days' => $dueDays,
        ];
    }

    public static function getFormMessage($error)
    {
        $type = gettype($error);

        if ($type == 'string') {
            return '
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div>' . $error . '</div>
                    </div>
                ';
        } else {
            if ($error['show']) {
                return '
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div>' . $error['message'] . '</div>
                    </div>
                ';
            } else {
                return '';
            }
        }
    }

    public static function getEventColor($event)
    {
        if (self::containsMany($event, ['create', 'login'])) {
            return 'success';
        } else if (self::containsMany($event, ['update'])) {
            return 'warning';
        } else if (self::containsMany($event, ['delete', 'logout'])) {
            return 'danger';
        } else {
            return 'primary';
        }
    }

    public static function containsMany($compare_word, $words)
    {
        foreach ($words as $word) {
            if (Str::contains(Str::lower($compare_word), $word))
                return true;
        }

        return false;
    }
}
