<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @api {post} /api/login User Login
 * @apiVersion 1.0.0
 * @apiName Login
 * @apiGroup Authentication
 * @apiPermission none
 *
 * @apiDescription Authenticates a user with email and password, returning an access token.
 *
 * @apiParam {String} email User's email address (must be valid format).
 * @apiParam {String} password User's password.
 *
 * @apiSuccess {Object} user User object containing profile details.
 * @apiSuccess {String} token Sanctum plain text access token.
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "user": {
 *         "id": 1,
 *         "name": "John Doe",
 *         "email": "john@example.com",
 *         "created_at": "2026-01-01T00:00:00.000000Z",
 *         "updated_at": "2026-01-01T00:00:00.000000Z"
 *       },
 *       "token": "1|LaravelSanctumTokenStringHere..."
 *     }
 *
 * @apiErrorExample {json} Unauthorized-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "message": "Invalid email or password"
 *     }
 */

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
