<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permit_type_id',
        'application_number',
        'status',
        'purpose',
        'location',
        'total_fee',
        'issue_date',
        'expiry_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    // 🔗 Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permitType()
    {
        return $this->belongsTo(PermitType::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function verification()
    {
        return $this->hasOne(Verification::class);
    }

    public function approval()
    {
        return $this->hasOne(Approval::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // 🔧 Helper
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function markAsIssued()
    {
        $this->status = 'issued';
        $this->issue_date = now();
        $this->expiry_date = now()->addDays($this->permitType->default_duration_days);
        $this->save();
    }
}
