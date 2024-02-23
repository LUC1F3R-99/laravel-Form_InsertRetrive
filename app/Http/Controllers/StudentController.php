<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file("avatar");
        $filename =   "IMG-". time() . "." . $file->getClientOriginalExtension();
        $file->storeAs("public/images", $filename);

        $stuData = [
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->mail,
            'avatar' => $filename,
        ];
        Student::create($stuData);

        return response()->json([
            'status'=> 200,
        ]);
    }
}
