<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'app_id',
        'gate_id',
    ];
    
    
    public function app()
    {
        return $this->belongsTo(App::class,'app_id');
    }
    
    public function gate()
    {
        return $this->belongsTo(Gate::class,'gate_id');
    }
    
    
    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class,'role_id');
    }

    
    public function user()
    {
        return $this->hasMany(User::class,'role_id');
    }
}
