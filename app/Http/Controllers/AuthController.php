<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }


    public function register(RegisterRequest $request) {
        // validate user input
        $userInput = $request->validated();

        // create new user
        $user = $this->authService->register($userInput);
        $token = $user->createToken("messenger_session_token");

        return response()->json([
            'data' => [
                'user' => $user,
                'access_token' => $token->accessToken,
                'token_expires_at' => $token->token["expires_at"]
            ]
        ], Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        // validate user input
        $userInput = $request->validated();

        // create new user
        $user = $this->authService->getUserByEmail($userInput["email"]);

        if(!$user || !password_verify($userInput["password"], $user["password"])) {
            return response()->json([
                "success" => false,
                "errorCode" => 'invalid_credentials',
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken("messenger_session_token");

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'access_token' => $token->accessToken,
                'token_expires_at' => $token->token["expires_at"]
            ]
        ], Response::HTTP_OK);
    }

    public function show() {
        $user = Auth::user();

        if(!$user) {
            return response()->json([
                'success' => false,
                'errorCode' => 'invalid_token'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'data'=> [
                'user'=> $user
            ]
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request) {
        $userId = $request->user()["id"];
        $success = $this->authService->deleteUser($userId);

        if (!$success) {
            return response()->json([
                'success'=> false,
                'errorCode'=> 'internal_server_error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['success' => true]);
    }
}
