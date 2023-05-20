<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Schools;

class StudentsController extends Controller
{

    public function store(Request $request)
    {
        // Önce en yüksek order değerini alın
        $maxOrder = Students::where('school_id', $request->school_id)->max('order');
        $order = $maxOrder + 1;

        $student = new Students;
        $student->name = $request->name;
        $student->school_id = $request->school_id;
        $student->order = $order;
        $student->save();


        Mail::to("ogulcan.odemis28@gmail.com")->send(new TestEmail("Yeni Öğrenci Eklendi"));

        return response()->json([
            'success' => true,
            'message' => 'Öğrenci başarıyla eklendi.',
            'data' => $student
        ]);
    }

    public function destroy($id)
    {
        $student = Students::findOrFail($id);
        $schoolId = $student->school_id;
        $order = $student->order;

        $student->delete();

        // Silinen öğrencinin order değerinden büyük olan öğrencilerin order değerlerini bir birim azaltın
        Students::where('school_id', $schoolId)
            ->where('order', '>', $order)
            ->decrement('order');


        Mail::to("ogulcan.odemis28@gmail.com")->send(new TestEmail("Öğrenci Silindi"));

        return response()->json([
            'success' => true,
            'message' => 'Öğrenci başarıyla silindi.'
        ]);
    }

    public function index()
    {
        $students = Students::with("schools:id,name")->get();


        $html = "";
        if($students->count() > 0) {
            foreach ($students as $i => $student) {
                $html .= '<tr><th scope="row">'.($i+1).'</th><td>'.$student->name.'</td><td>'.$student->schools->name.'</td><td>'.$student->order.'</td><td><a href="javascript:void(0)"  class="btn btn-danger rounded-0 shadow-none float-end py-0 px-4" onclick="ogrenciSil('.$student->id.')">Sil</a></td></tr>';
            }
        } else {
            $html = '<tr><td colspan="4" class="text-center">Herhangi Bir Öğrenci Verisi Bulunamadı.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'data' => $students,
            'html' => $html,
        ]);
    }

    public function show($id)
    {
        $student = Students::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $student,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'school_id' => 'required',
        ]);

        $student = Students::findOrFail($id);
        $student->update($validatedData);


        // Öğrencinin bağlı olduğu okulu al
        $schools = Schools::all();

        foreach ($schools as $school) {
            // Okuldaki öğrencileri order değerine göre sırala ve baştan sıralı order değerlerini ata
            $school->students()
                ->get()
                ->each(function ($student, $index) {
                    $student->order = $index + 1;
                    $student->save();
                });
        }

        Mail::to("ogulcan.odemis28@gmail.com")->send(new TestEmail("Öğrenci Düzenlendi"));
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $student,
        ]);
    }

}
