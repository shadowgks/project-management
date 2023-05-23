<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{

    public static function get_days_of_week()
    {
        return [
            0 => 'Mo',
            1 => 'Tu',
            2 => 'We',
            3 => 'Th',
            4 => 'Fr',
            5 => 'Sa',
            6 => 'Su',
        ];
    }

    public static function get_days_of_month($month)
    {
        return \Carbon\Carbon::now()->month($month)->daysInMonth;
    }

    public static function get_all_days_of_month()
    {
        $days = [];

        for ($i = 1; $i <= 31; $i++)
            array_push($days, $i);

        return $days;
    }

    public static function get_months($to_object = true)
    {
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            if ($to_object) {
                array_push($months, (object) [
                    'id' => $m,
                    'value' => date('F', mktime(0, 0, 0, $m, 1, date('Y'))),
                ]);
            } else {
                array_push($months, [
                    'id' => $m,
                    'value' => date('F', mktime(0, 0, 0, $m, 1, date('Y'))),
                ]);
            }
        }
        return $months;
    }

    public static function get_years($start_year)
    {
        return array_reverse(range(Carbon::now()->year, $start_year));
    }

    public static function compare_months($date, $month, $operation = '=')
    {
        $new_month = (int) Carbon::parse($date)->format("m");

        switch ($operation) {
            case '<':
                return $new_month < $month;
                break;

            case '<=':
                return $new_month <= $month;
                break;

            case '=':
                return $new_month == $month;
                break;

            case '>=':
                return $new_month >= $month;
                break;

            case '>':
                return $new_month > $month;
                break;

            default:
                throw new \Exception($operation . ' is not allowed!');
                break;
        }
    }

    public static function compare_years($date, $year, $operation = '=')
    {
        $new_year = (int) Carbon::parse($date)->format("Y");

        switch ($operation) {
            case '<':
                return $new_year < $year;
                break;

            case '<=':
                return $new_year <= $year;
                break;

            case '=':
                return $new_year == $year;
                break;

            case '>=':
                return $new_year >= $year;
                break;

            case '>':
                return $new_year > $year;
                break;

            default:
                throw new \Exception($operation . ' is not allowed!');
                break;
        }
    }

    public static function get_first_year($model, $column = 'created_at')
    {
        $date = $model::select($column)->orderBy($column)->first()->$column;

        if (isset($date->year))
            return $date->year;
        else
            return $date;
    }

    public static function getFilterDateValues()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'From the beginning',
            ],
            (object) [
                'id' => 2,
                'name' => 'This month',
            ],
            (object) [
                'id' => 3,
                'name' => 'Last month',
            ],
            (object) [
                'id' => 4,
                'name' => 'This year',
            ],
            (object) [
                'id' => 5,
                'name' => 'Last year',
            ],
            (object) [
                'id' => 6,
                'name' => 'Last 3 months',
            ],
            (object) [
                'id' => 7,
                'name' => 'Last 6 months',
            ],
            (object) [
                'id' => 8,
                'name' => 'Last 12 months',
            ],
            (object) [
                'id' => 9,
                'name' => 'Period',
            ],
        ];
    }
}
