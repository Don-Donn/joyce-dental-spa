<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medical_history',
        'allergies',
        'smoker',
        'notes',
    ];


    public function patient () {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
