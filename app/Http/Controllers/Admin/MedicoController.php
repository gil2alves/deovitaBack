<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Extrair os 6 primeiros dígitos do CPF e criptografar para usar como senha
            $password = bcrypt(substr(str_replace(['.', '-'], '', $request->cpf), 0, 6));

            // Criar user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->name_user = $request->name_user;
            $user->password = $password;
            $user->group_id = 2;
            $user->save();

            // Criar doctor
            $doctor = new Doctor();
            $doctor->user_id = $user->id;
            $doctor->crm = $request->crm;
            $doctor->cpf = $request->cpf;
            $doctor->sex = $request->sex;
            $doctor->date_birth = $request->date_birth;
            $doctor->phone = $request->phone;
            $doctor->address = $request->address;
            $doctor->city = $request->city;
            $doctor->state = $request->state;
            $doctor->save();


            DB::commit();


            return response()->json([
                'success' => true,
                'message' => 'Medico cadastrado com sucesso!'
            ]);
        } catch (\Exception $e) {

            DB::rollback();


            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar medico.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getExams(Request $request)
    {
        $filtro = $request->only(['name']);
        $pageSize = $request->input('pageSize', 5);


        $examsQuery = Exam::query();


        foreach ($filtro as $campo => $value) {
            if ($value) {
                $examsQuery->where($campo, 'like', "%$value%");
            }
        }

        // Realiza a paginação com o número de itens por página especificado
        $exams = $examsQuery->paginate($pageSize);

        // Retorna os dados em formato JSON
        return response()->json([
            'exams' => $exams->items(),
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
