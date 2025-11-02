<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'default_duration_days'
    ];

    public function permitApplications()
    {
        return $this->hasMany(PermitApplication::class);
    }
}
