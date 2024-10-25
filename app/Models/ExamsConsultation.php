<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamsConsultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_id',
        'consultation_record_id',
    ];

    public function consultationRecord()
    {
        return $this->belongsTo(ConsultationRecord::class, 'consultation_record_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
