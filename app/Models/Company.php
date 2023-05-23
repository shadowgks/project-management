<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "name",
        "activity_id",
        "capital",
        "vat",
        "common_identifier",
        "commercial_register",
        "social_security",
        "active",
        "created_at",
        "updated_at",
    ];

    const COMMERCIAL = 1;
    const PRODUCTION = 2;
    const SERVICE_DELIVERY = 3;

    public static function getCompanies($except_company_id = null)
    {
        $companies = self::select('*');

        if ($except_company_id != null) {
            $companies = $companies->where('id', '!=', $except_company_id);
        }

        $companies = $companies->with('created_by')->get();
        return $companies;
    }

    public static function getActivities()
    {
        return [
            [
                'id' => self::COMMERCIAL,
                'text' => __('commercial'),
            ],
            [
                'id' => self::PRODUCTION,
                'text' => __('production'),
            ],
            [
                'id' => self::SERVICE_DELIVERY,
                'text' => __('service delivery'),
            ],
        ];
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "app_module_id", "id");
    }

    public function files()
    {
        return $this->hasMany(Upload::class, "app_module_id", "id");
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, "app_module_id", "id");
    }

    // Relations

    public function drop_downs()
    {
        return $this->belongsTo(\App\Models\DropDown::class, "activity_id");
    }
}
