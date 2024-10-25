<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionRevenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_record_id',
        'prescription',

    ];
}
