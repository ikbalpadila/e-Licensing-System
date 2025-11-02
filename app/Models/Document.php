<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_application_id', 'name', 'file_path', 'mime_type', 'size_kb'
    ];

    public function permitApplication()
    {
        return $this->belongsTo(PermitApplication::class);
    }
}
