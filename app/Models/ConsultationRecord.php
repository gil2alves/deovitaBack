<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRecord extends Model
{
    protected $fillable = [
        'doctor_id', 'patient_id', 'date', 'start_time', 'end_time', 'status'
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function examsConsultations()
    {
        return $this->hasMany(ExamsConsultation::class, 'consultation_record_id');
    }
}
