<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonnelElementPedagoguique;

class PersonnelElementPedagoguiqueController extends Controller
{

    public function storeTeacherElement(Request $request, $id, $etape_id)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'element_id' => 'required|exists:t_modules_etape,id',
            'teacher_id' => 'required|exists:t_personnel,id'
        ]);

        PersonnelElementPedagoguique::create([
            'personnel_id' => $request->teacher_id,
            'id_element_pedago' => $request->element_id,
        ]);

        return response()->json(['message' => 'Professeur assigné avec succès'], 200);
    }
}
