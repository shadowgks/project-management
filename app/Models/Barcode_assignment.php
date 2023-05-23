<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode_assignment extends Model
{
    use HasFactory;

    public function numbering_setting()
    {
        return $this->hasOne(Numbering_setting::class);
    }

    public function created_by()
    {
        return $this->hasOne(User::class);
    }
}
