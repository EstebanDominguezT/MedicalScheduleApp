<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'day',
        'employee_id',
        'lunch_start_time',
        'lunch_end_time',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
