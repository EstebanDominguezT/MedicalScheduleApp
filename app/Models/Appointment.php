<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'start_datetime',
        'end_datetime',
        'created_by'
    ];

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Employee::class, 'patient_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

}
