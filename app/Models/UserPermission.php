<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'permission_id',
        'value',
    ];

    
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
