<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFilter extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the CustomFilter
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the setting that owns the CustomFilter
     */
    public function setting()
    {
        return $this->hasOne(ProjectSetting::class, 'id', 'setting_id');
    }
}
