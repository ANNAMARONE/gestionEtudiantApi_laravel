<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class AuthController extends Controller
{
    // Resgister admin
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|confirmed|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400); 
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json($user,201);
    }
    //login admin
    public function login(Request $request) {
        $credentials=request(['email','password']);
        if(!$token=auth()->attempt($credentials)) {
            return response()->json(['erreur'=>'Unauthorized'],401);
        }
        return $this->respondWithToken($token);
    }
    public function me(){
        return response()->json(auth()->user());
    }
    public function logout() {
        auth()->logout();
        return response()->json([
            'status' => true,
            'message' => 'Déconnexion réussie'
        ], 200);
    }
    
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
}

