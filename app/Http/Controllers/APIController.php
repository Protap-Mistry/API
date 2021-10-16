<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class APIController extends Controller
{   
    //without parameter
    // public function getUsers()
    // {
    //     $users= User::get();
    //     //return $users;
    //     //return response()->json($users);
    //     return response()->json(["users"=>$users]); //pass as an object "users"
    // }

    //with parameter
    public function getUsers($id=null)
    {
        if(empty($id))
        {
            $users= User::get();
            return response()->json(["users"=>$users], 200); //200 means Successfull OK message code
        }else {
            $users= User::find($id);
            return response()->json(["users"=>$users], 200);
        }
    }

    public function addUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $userData= $request->input();
            // echo "<pre>";
            // print_r($userData);
            // die;

            //simple validation

            // if(empty($userData['name']) || empty($userData['email']) || empty($userData['password']))
            // {
            //     $error_message= "Field must not be empty.";               
            // }
            // if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            //     $error_message= "This is not a valid email address.";
            // }

            // $emailCount= User::where('email', $userData['email'])->count();
            // if($emailCount>0)
            // {
            //     $error_message= "This email address already exist.";
            // }

            // if(isset($error_message) && !empty($error_message))
            // {
            //     return response()->json(["Status"=>false, "Message"=>$error_message], 422); //422 is the unprocessable entity code when validation failed
            // }

            //advance validation

            $rules= [
                "name" => "required|regex:/^[\pL\s\ .-]+$/u",
                "email" => "required|email|unique:users",
                "password" => "required"
            ];
            $customMessages= [
                'name.required' => 'Name is required',
                'name.regex' => 'Valid name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'email.unique' => 'Email already exist',
                'password.required' => 'Password is required'
            ];    
            $validator= Validator::make($userData, $rules, $customMessages);

            if($validator->fails())
            {
                return response()->json($validator->errors(), 422); //422 is the unprocessable entity code when validation failed
            }

            $user= new User;
            $user->name= $userData['name'];
            $user->email= $userData['email'];
            $user->password= bcrypt($userData['password']);
            $user->save();
            return response()->json(["Message"=>"User added successfully !!!"], 201); //201 means the code when data is created
        }
    }

    public function addMultipleUsers(Request $request)
    {
        if($request->isMethod('post'))
        {
            $userData= $request->input();
            // echo "<pre>";
            // print_r($userData);
            // die;

             $rules= [
                "users.*.name" => "required|regex:/^[\pL\s\ .-]+$/u", //users is the table name and * means any or all index number of the array
                "users.*.email" => "required|email|unique:users",
                "users.*.password" => "required"
            ];
            $validator= Validator::make($userData, $rules);

            if($validator->fails())
            {
                return response()->json($validator->errors(), 422); //422 is the unprocessable entity code when validation failed
            }

            foreach ($userData['users'] as $key => $value) { //['users'] is the object name that define when json input gives in postman
                $user= new User;
                $user->name= $value['name'];
                $user->email= $value['email'];
                $user->password= bcrypt($value['password']);
                $user->save();
                
            }
            return response()->json(["Message"=>"Multiple User added successfully !!!"], 201);
        }
    }
}
