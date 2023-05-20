<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schools;

class SchoolsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $student = Schools::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Created successfully.',
            'data' => $student,
        ]);
    }

    public function index()
    {
        $students = Schools::all();

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }

    public function show($id)
    {
        $student = Schools::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $student,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $student = Schools::findOrFail($id);
        $student->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully.',
            'data' => $student,
        ]);
    }


    public function destroy($id)
    {
        $student = Schools::findOrFail($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

}

