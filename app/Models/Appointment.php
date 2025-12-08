<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'service_id',
        'date',
        'time',
        'status',
        'cancellation_requested',  // new: tracks if patient requested cancellation
        'cancellation_reason',     // new: optional reason for cancellation
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // RELATIONSHIPS
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
