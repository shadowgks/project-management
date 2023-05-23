<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfTemplates extends Model
{
    use HasFactory;

    public function header()
    {
        return $this->hasOne(PdfHeader::class);
    }
    public function footer()
    {
        return $this->hasOne(PdfFooter::class);
    }
}
