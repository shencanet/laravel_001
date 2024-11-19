<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Importar Validator correctamente
use App\Models\Student;

class studentController extends Controller
{
    public function index()
    {
        
       $students =  Student::all();

       if($students->isEmpty()){
           return response()->json(['message' => 'No hay estudiantes registrados'], 404);
       }

       return response()->json($students, 200);


        
    }

    public function show($id)
    {
        $student = Student::find($id); // Usa el modelo correcto
        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }
        return response()->json($student);
    }



    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|MAX:10',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:Esp,Eng',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error en la validación de datos', 'errors' => $validator->errors()], 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);

        return response()->json(['message' => 'Estudiante creado con éxito', 'student' => $student], 201);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|MAX:30',
            'email' => 'required|email|unique:student,email,' . $id,
            'phone' => 'required|digits:10',
            'language' => 'required|in:Esp,Eng',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error en la validación de datos', 'errors' => $validator->errors()], 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->save();
        
        $data = ['message' => 'Estudiante actualizado con éxito', 'student' => $student];

    


    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $student->delete();
        $data = ['message' => 'Estudiante eliminado con éxito', 'student' => $student];
    }

    public function update_partial(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'MAX:10',
            'email' => 'email|unique:student,email,',
            'phone' => 'digits:10',
            'language' => 'in:Esp,Eng',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error en la validación de datos', 'errors' => $validator->errors()], 400);
        }

        if ($request->has('name')) {
            $student->name = $request->name;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }

        if ($request->has('language')) {
            $student->language = $request->language;
        }

        $student->save();
        $data = ['message' => 'Estudiante actualizado con éxito', 'student' => $student];
    }
}
