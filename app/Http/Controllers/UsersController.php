<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 

use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request;

use App\User;
use App\Student;

class UsersController extends Controller
{
    //

    public function getStudents() {
        return response()->json([
            'status' => 'success',
            'data' => ['name' => 'Olumide']
        ]);
    }


    public function login(Request $request) {
        $data = $request->all();

        /**
         * Check if user with this email exists
         */
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('anything')->accessToken; 

            return response()->json([
                'status' => 'success',
                'data' => $user,
                'token' => $token
            ]);
        } 
        else{ 
            return response()->json([
                'status'=> 'failed',
                'error'=>'Unauthorised'], 401); 
        } 

    }

    public function register(Request $request) {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $user
        ]);
 
    }


    public function myProfile() {
        $me = Auth::user();
        $me['student_info'] = Student::where('user_id', $me['id'])->first();

        return response()->json([
            'status' => 'success',
            'message' => 'My data retrieved successfully',
            'data' => $me
        ]);
    }
}
