<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Student;

class StudentController extends Controller
{
    private $status     =   200;
    // --------------- [ Save Student function ] -------------
    public function createStudent(Request $request) {

        // validate inputs
        $validator          =       Validator::make($request->all(),
            [
                "first_name"        =>      "required",
                "last_name"         =>      "required",
                "email"             =>      "required|email",
                "phone"             =>      "required|numeric"
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $studentArray           =       array(
            "first_name"            =>      $request->first_name,
            "last_name"             =>      $request->last_name,
            "full_name"             =>      $request->first_name . " " . $request->last_name,
            "email"                 =>      $request->email,
            "phone"                 =>      $request->phone
        );

        $student        =       Student::create($studentArray);
        if(!is_null($student)) {
            return response()->json(["status" => $this->status, "success" => true, "message" => "student record created successfully", "data" => $student]);
        }

        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }


    // --------------- [ Students Listing ] -------------------
    public function studentsListing() {
        $students       =       Student::all();
        if(count($students) > 0) {
            return response()->json(["status" => $this->status, "success" => true, "count" => count($students), "data" => $students]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }
    }

    // --------------- [ Student Detail ] ----------------
    public function studentDetail($id) {
        $student        =       Student::find($id);
        if(!is_null($student)) {
            return response()->json(["status" => $this->status, "success" => true, "data" => $student]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no student found"]);
        }
    }
}
