<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySite extends Model
{
    use HasFactory;
    protected $guarded = [];

    const STOCK = 'stock';
    const ADMINISTRATION = 'administration';
    const PRODUCTION = 'production';

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::orderByDesc('id')->get();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function get_site_of_company($company_id)
    {
        return self::where('company_id', $company_id)->orderByDesc('id')->get();
    }

    public static function _save($data, $id = null)
    {
        if ($id == null) {
            $model = new self;
        } else {
            $model = self::find($id);
            $model->user_id = Auth::id();
        }

        $model->fill($data);
        $model->save();

        return $model->id;
    }

    public static function _delete($id)
    {
        self::where('id', $id)->delete();
    }

    public static function getTypes()
    {
        return [
            [
                'id' => self::STOCK,
                'text' => __('stock'),
            ],
            [
                'id' => self::ADMINISTRATION,
                'text' => __('administration'),
            ],
            [
                'id' => self::PRODUCTION,
                'text' => __('production'),
            ],
        ];
    }
}
