<?php

namespace App\Http\Controllers;

use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    //

    public function getStudents() {

        $students = Student::get();

        return response()->json([

            'status' => 'success',
            'data' => $students
        ]);
    }


    public function createStudentAccount(Request $request) {
        $user = Auth::user(); 
        $data = $request->all();
        $data['name'] = $user['name'];
        $data['user_id'] = $user['id'];
        $data['matric_number'] = 'UNI/' . rand(1111111111, 9999999999);

        /**
         * Check if the user already has a student account
         */

        if(Student::where('user_id', $data['user_id'])->exists()){
            return response()->json([

                'status' => 'failed',
                'message' => 'Student already exists'
            ]);
        } 

        $student = Student::create($data);

        return response()->json([

            'status' => 'success',
            'message' => 'Student account created successfully',
            'data' => $student
        ]);
    }
}
