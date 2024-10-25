<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';


    public function getCpfAttribute($value)
    {
        return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
    }

    public function getPhoneAttribute($value)
    {
        // Remove qualquer caractere não numérico
        $cleaned = preg_replace('/\D/', '', $value);
    
        // Verifica se o número tem 10 ou 11 dígitos
        if (strlen($cleaned) === 10) {
            // Formato (XX) XXXX-XXXX
            return '(' . substr($cleaned, 0, 2) . ') ' . substr($cleaned, 2, 4) . '-' . substr($cleaned, 6);
        } elseif (strlen($cleaned) === 11) {
            // Formato (XX) XXXXX-XXXX
            return '(' . substr($cleaned, 0, 2) . ') ' . substr($cleaned, 2, 5) . '-' . substr($cleaned, 7);
        }
    
        // Se o número não tiver o tamanho esperado, retorna o valor original sem formatação
        return $value;
    }
    

    public static function withUserDetails($groupId = 3)
    {
        return self::join('users', 'patients.user_id', '=', 'users.id')
            ->where('users.group_id', $groupId)
            ->select('users.*', 'patients.date_birth', 'patients.cpf', 'patients.phone', 'patients.sex');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consultationRecords()
    {
        return $this->hasMany(ConsultationRecord::class, 'patient_id');
    }
}
