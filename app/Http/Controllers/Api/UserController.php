<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $token['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => true,"data"=>$token], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 422);            
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }

    public function details() 
    { 
        if(Auth::check()){
            $user = Auth::user(); 

            return response()->json(['success' => $user], $this-> successStatus);
        }else{
            return response()->json(['error'=>["Usuário não autorizado"]], 401);
        }
         
    } 
}
