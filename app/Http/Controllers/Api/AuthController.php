<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/login",
     *   operationId="login",
     *   summary="Login",
     *   tags={"Authentication"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="email",
     *           description="Email",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Password",
     *           type="string",
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Entity",
     *   ),
     * )
     */
    public function login(Request $request)
    {
        $inputs = $request->all();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $validator = Validator::make($inputs, [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Login failed',
        //         'data' => null,
        //         'errors' => $validator->errors()->toArray(),
        //     ], 422);
        // }

        if (auth()->attempt($inputs)) {
            return response()->json([
                'success' => true,
                'message' => 'Login success',
                'data' => [
                    'user' => auth()->user(),
                    'token' => auth()->user()->createToken('authToken')->accessToken,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'These credentials do not match our records.',
                'data' => null,
            ]);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/register",
     *   tags={"Authentication"},
     *   summary="Register",
     *   operationId="register",
     *   description="Create new user account",
     *
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *        mediaType="application/x-www-form-urlencoded",
     *        @OA\Schema(
     *          @OA\Property(
     *            description="Email",
     *            property="email",
     *            type="string",
     *          ),
     *          @OA\Property(
     *            description="Name",
     *            property="name",
     *            type="string",
     *          ),
     *          @OA\Property(
     *            description="Password",
     *            property="password",
     *            type="string",
     *           ),
     *         )
     *       )
     *    ),
     *
     *   @OA\Response(
     *      response=201,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthorized"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *   @OA\Response(
     *       response=403,
     *       description="Forbidden"
     *   )
     *)
     **/
    /**
     * Register user
     * Create new user
     */
    public function register(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Register failed',
                'data' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        $inputs['password'] = Hash::make($inputs['password']);
        $user = User::create($inputs);
        $token = $user->createToken('authToken')->accessToken;

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register success',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register failed',
                'data' => null,
            ]);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/logout",
     *   operationId="logout",
     *   summary="Logout",
     *   description="Logout from application",
     *   tags={"Authentication"},
     *   security={{"api_key": {}}},
     *   @OA\Response(
     *     response="200",
     *     description="Logout success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     * )
     */
    public function logout()
    {
        if (auth()->check()) {
            $token = auth()->user()->token();
            $token->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logout success',
                'data' => null,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'data' => null,
            ], 401);
        }
    }
}
