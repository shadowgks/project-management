<?php

namespace App\Helpers;

class NumberingHelper
{
    const types = [
        [
            'id' => 'd',
            'text' => 'Day',
        ],
        // [
        //     'id' => 'W',
        //     'text' => 'Week',
        // ],
        [
            'id' => 'm',
            'text' => 'Month (MM)',
        ],
        [
            'id' => 'y',
            'text' => 'Year (YY)',
        ],
        [
            'id' => 'Y',
            'text' => 'Year (YYYY)',
        ],
    ];

    public static function getElementTypes()
    {
        return self::types;
    }

    public static function getElementType($id)
    {
        $result = null;

        foreach (self::types as $key => $type) {
            if ($type['id'] == $id) {
                $result = $type;
                break;
            }
        }

        return $result;
    }
}
