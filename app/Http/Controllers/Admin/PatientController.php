<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        $filtro = $request->only(['name']);
        $pageSize = $request->input('pageSize', 5);

        // Inicia a query utilizando o método definido no modelo
        $patientQuery = Patient::withUserDetails()->newQuery();

        // Aplica filtros, se houver
        foreach ($filtro as $campo => $value) {
            if ($value) {
                $patientQuery->where('users.' . $campo, 'like', "%$value%");
            }
        }

        // Realiza a paginação com o número de itens por página especificado
        $patients = $patientQuery->paginate($pageSize);

        // Retorna os dados em formato JSON
        return response()->json([
            'patients' => $patients->items(),
        ], 200);
    }




    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $firstName = strtolower(explode(' ', trim($request->name))[0]);
            $birthDay = date('d', strtotime($request->date_birth));
            $nameUser = $firstName . $birthDay;
            $password = substr(str_replace(['.', '-'], '', $request->cpf), 0, 6);
    
            // Criar user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->name_user = $nameUser;
            $user->password = bcrypt($password);
            $user->group_id = 3;
            $user->save();
    
            // Criar patient
            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->cpf = $request->cpf;
            $patient->sex = strtolower($request->sex);  // Convertendo para minúsculas
            $patient->date_birth = $request->date_birth;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->city = $request->city;
            $patient->state = $request->state;
            $patient->save();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Paciente cadastrado com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar paciente.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
     
}
