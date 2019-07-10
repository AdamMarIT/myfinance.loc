<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        
        $user = User::where('email', $credentials['email'])->first();
		//dd(bcrypt($credentials['password']));
		if (Hash::check($credentials['password'], $user->password)){
			$token = JWTAuth::fromUser($user);
			return $this->respondWithToken($token);
			//return response()->json(['ok' => 'Authorized'], 200);

		} else {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

        // if (! $token = auth('api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
        /**
     * Register a new user
     */
    public function register(Request $request)
    {
        // $v = Validator::make($request->all(), [
        //     'name' => 'required|min:3',
        //     'email' => 'required|email|unique:users',
        //     'password'  => 'required|min:3|confirmed',
        // ]);
        // if ($v->fails())
        // {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $v->errors()
        //     ], 422);
        // }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

}
