<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function consultationRecords()
    {
        return $this->hasMany(ConsultationRecord::class, 'doctor_id');
    }
}
