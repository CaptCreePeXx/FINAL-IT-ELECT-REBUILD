<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',  // <-- IMPORTANT
        'status',
    ];

    /**
     * Attributes hidden from arrays
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIPS
     */

    // Each user belongs to a role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Each user can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function dentistAppointments()
    {
        return $this->hasMany(Appointment::class, 'dentist_id');
    }

}
