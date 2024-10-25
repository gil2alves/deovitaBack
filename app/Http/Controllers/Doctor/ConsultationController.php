<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRecord;
use App\Models\Doctor;
use App\Models\ExamsConsultation;
use App\Models\Patient;
use App\Models\PrescriptionRevenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        // Obter o ID do médico logado
        $doctorId = Doctor::where('user_id', Auth::id())->firstOrFail()->id;

        // Determinar a página atual e o tamanho da página
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);

        // Buscar registros de consulta para esse médico com paginação
        $paginatedConsultations = ConsultationRecord::with(['patient.user', 'examsConsultations.exam'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'finished')
            ->paginate($pageSize, ['*'], 'page', $page);

        // Transformar os dados para incluir a duração calculada
        $consultations = collect($paginatedConsultations->items())
            ->map(function ($consultation) {
                $duration = null;
                if ($consultation->start_time && $consultation->end_time) {
                    $start = Carbon::parse($consultation->start_time);
                    $end = Carbon::parse($consultation->end_time);
                    $duration = $end->diffInMinutes($start) . ' minutos';
                }

                return [
                    'name' => $consultation->patient->user->name,
                    'email' => $consultation->patient->user->email,
                    'date' =>Carbon::parse($consultation->date)->format('d/m/Y'),
                    'phone' => $this->formatPhone($consultation->patient->phone),
                    'sex' => $consultation->patient->sex,
                    'exams' => $consultation->examsConsultations->map(function ($ec) {
                        return $ec->exam->type_of_exam;
                    })->toArray()
                ];
            });

        // Devolver dados paginados com metadados
        return response()->json([
            'consultations' => $consultations,
            'totalPages' => $paginatedConsultations->lastPage(),
            'currentPage' => $paginatedConsultations->currentPage(),
            'totalItems' => $paginatedConsultations->total()
        ]);
    }
    public function consultationStart()
    {
        $consultationRecord = new ConsultationRecord([
            'status' => 'start',
            'start_time' => Carbon::now(),
            'date' => Carbon::today()->toDateString(),
        ]);

        $consultationRecord->save();

        return response()->json([
            'idConsultation' => $consultationRecord->id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patientId' => 'required|integer',
        ]);
        $consultationId = $request->input('idConsultation');
        if (!$consultationId) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel iniciar a consulta, tente novamente',

            ], 400);
        }
        $consultationRecord = ConsultationRecord::find($consultationId);

        DB::beginTransaction();

        try {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if (!$doctor) {
                return response()->json(['error' => 'Apenas médicos podem salvar consultas'], 404);
            }

            $patient = Patient::where('user_id', $request->patientId)->first();
            if (!$patient) {
                return response()->json(['error' => 'Paciente não encontrado'], 404);
            }

            $consultationRecord->update([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'end_time' => Carbon::now(),
                'status' => 'finished'
            ]);


            // Processa cada prescrição individualmente
            foreach ($request->prescription as $prescriptionText) {
                $prescriptionRevenue = new PrescriptionRevenue([
                    'consultation_record_id' => $consultationRecord->id,
                    'prescription' => $prescriptionText,
                ]);
                $prescriptionRevenue->save();
            }

            // Processa cada exame individualmente
            foreach ($request->selectedExams as $exam) {
                $examConsultation = new ExamsConsultation([
                    'consultation_record_id' => $consultationRecord->id,
                    'exam_id' => $exam['id'],
                ]);
                $examConsultation->save();
            }

            DB::commit();
            return response()->json(['message' => 'Consulta finalizada com sucesso!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar consulta medic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        // Função para formatar o telefone
        private function formatPhone($phone)
        {
            // Remove qualquer caractere que não seja número
            $cleaned = preg_replace('/\D/', '', $phone);
    
            // Verifica se o número tem 10 ou 11 dígitos
            if (strlen($cleaned) === 10) {
                // Formato (XX) XXXX-XXXX
                return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
            } elseif (strlen($cleaned) === 11) {
                // Formato (XX) XXXXX-XXXX
                return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cleaned);
            }
    
            // Retorna o número sem formatação se não for possível formatar
            return $phone;
        }    
}
