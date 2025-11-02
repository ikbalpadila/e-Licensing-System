<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 🔗 Relasi
    public function permitApplications()
    {
        return $this->hasMany(PermitApplication::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Officer verifications
    public function verifications()
    {
        return $this->hasMany(Verification::class, 'officer_id');
    }

    // Supervisor approvals
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'supervisor_id');
    }

    // Helper: check role
    public function isRole($role)
    {
        return $this->role === $role;
    }
}
