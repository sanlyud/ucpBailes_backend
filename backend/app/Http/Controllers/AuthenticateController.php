<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{

//    public function __construct()
//    {
//        // Apply the jwt.auth middleware to all methods in this controller
//        // except for the authenticate method. We don't want to prevent
//        // the user from retrieving their token if they don't already have it
//        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
//    }


    private $user;
    private $jwtauth;
    public function __construct(User $user, JWTAuth $jwtauth)
    {
        $this->user = $user;
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $newUser = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        if (!$newUser) {
            return response()->json(['failed_to_create_new_user'], 500);
        }
        //TODO: implement JWT
        return response()->json(['registered successfully']);
    }

    public function login(Request $request)
    {
        // get user credentials: email, password
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    /**
     * Return the user
     *
     * @return Response
     */
    public function index()
    {

        // Retrieve all the users in the database and return them
        $users = User::all();

        return $users;
    }

    /**
     * Return a JWT
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
}
