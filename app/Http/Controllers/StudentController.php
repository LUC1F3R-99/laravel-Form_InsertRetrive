<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mail' => 'required|email|max:255',
        ]);

        // Store the uploaded file
        $filename = "IMG-" . time() . "." . $request->file("avatar")->getClientOriginalExtension();
        $request->file("avatar")->storeAs("public/images", $filename);

        // Create student data
        $stuData = [
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->mail,
            'avatar' => $filename,
        ];

        // Save student data
        Student::create($stuData);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function fetch()
    {
        // Retrieve all students in descending order by their IDs (assuming ID is auto-incrementing)
        $students = Student::orderBy('id', 'desc')->get();

        if ($students->isEmpty()) {
            return "<h3 align='center'>Nothing to show</h3>";
        }

        // Prepare the HTML response
        $response = "<table id='myTable' class='display'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

        // Loop through each student
        foreach ($students as $key => $student) {
            $response .= "<tr>
                        <td>" . $student->id . "</td>
                        <td> <img src='" . asset('storage/images/' . $student->avatar) . "' width='50px' height='40px' class='img-thumbnail rounded-circle' style='border-color: transparent;'></td>
                        <td>" . $student->first_name . "</td>
                        <td>" . $student->last_name . "</td>
                        <td>" . $student->email . "</td>
                        <td> <a href='' id='" . $student->id . "'class='StudentEdit' data-bs-toggle='modal'
                        data-bs-target='#editModal' ><button class='btn btn-primary'>Edit </button>|</a><a href='#' id='" . $student->id . "' class='deleteBtn' ><button class='btn btn-danger'>Delete</button></a></td>
                    </tr>";
        }

        $response .= "</tbody></table>";

        return $response;
    }

    public function edit(Request $request)
    {
        $userId = $request->id;

        $student = Student::find($userId);
        return response()->json($student);
    }

    public function update(Request $request)
    {

        $student = '';

        $student = Student::find($request->user_id);
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = "IMG-" . time() . "." . $request->file("avatar")->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);

            if($student->avatar){
                Storage::delete('public/images/' . $student->avatar);
            }
        } else {
            $filename = $student->avatar;
        }

        $stuData = [
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->mail,
            'avatar' => $filename,
        ];

        $student->update($stuData);
        return response()->json([
            'status' => 200,
        ]);

    }

    function delete(Request $req)
    {
        $id = $req->id;
        $studentData = Student::find($id);

        if(Storage::delete('public/images/'. $studentData->avatar)) {

            Student::destroy($id);
            return response()->json([
                'status' => 'ok',
            ]);
        } else{
            return response()->json([
                'status' => 'error',
            ]);
        }



    }

}
