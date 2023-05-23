<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFooter extends Model
{
    use HasFactory;

    public function pdfTemplates()
    {
        return $this->hasMany(PdfTemplates::class);
    }
}
