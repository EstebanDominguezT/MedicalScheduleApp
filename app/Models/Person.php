<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    
    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender_id',
        'date_of_birth',
        'national_id',
        'address',
        'postal_code',
        'phone_number'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function full_name()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}
