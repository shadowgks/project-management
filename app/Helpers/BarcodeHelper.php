<?php

namespace App\Helpers;

class BarcodeHelper
{
    const types = [
        'C39',
        'C39+',
        'C128',
        'C128A',
        'C128B',
        'C128C',
        'EAN2',
        'EAN5',
        'EAN8',
        'EAN13',
        'POSTNET',
        'PLANET',
        'RMS4CC',
        'KIX',
        'IMB',
        'CODABAR',
        'CODE11',
        'QRCODE',
        'PHARMA2T',
    ];

    public static function getBarcodeTypes()
    {
        return self::types;
    }

    // public static function getBarcodeType($id)
    // {
    //     $result = null;

    //     foreach (self::types as $key => $type) {
    //         if ($type['id'] == $id) {
    //             $result = $type;
    //             break;
    //         }
    //     }

    //     return $result;
    // }
}
