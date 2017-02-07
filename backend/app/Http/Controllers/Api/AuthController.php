<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Tymon\JWTAuth\JWTAuth;
use JWTAuthException;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    private $user;
    private $jwtauth;
    public function __construct(User $user, JWTAuth $jwtauth)
    {
        $this->user = $user;
        $this->jwtauth = $jwtauth;
    }

    public function register(Request $request)
    {
        $newUser = $this->user->create([
            'firstName' => $request->get('firstName'),
            'lastName' =>$request->get('lastName'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'schoolID' => $request->get('schoolID')

    ]);
    if (!$newUser) {
        return response()->json(['success' =>false, 'error' => 'failed_to_create_new_user'], 500);
    }
    //TODO: implement JWT
    return response()->json(['success' => true, 'teacherID' => $newUser->id]);
  }

    public function login(Request $request)
    {
        // get user credentials: email, password
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            $token = $this->jwtauth->attempt($credentials);
            if (!$token) {
                return response()->json(['success'=> false, 'error' => 'invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['success' => false, 'error' => 'failed_to_create_token'], 500);
        }
        $user = DB::table('users')->where('email', $request->get('email'))
            ->select('isAdmin')->first();
        if($user->isAdmin == "1")
            return response()->json(array('success' => true, 'token' => compact('token'), 'role' => 'ADMIN'));
        else
            return response()->json(array('success' => true, 'token' => compact('token'), 'role' => 'AUTHORIZED'));
    }
}
