<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthTokenResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    function register(LoginRequest $request) {
        // validate user input
        $userInput = $request->validated();

        // create new user



        return response()->json([
            'user' => []
        ], Response::HTTP_BAD_REQUEST);
    }

    public function index()
    {
        //
    }


    public function create(LoginRequest $request)
    {
        error_log('create here');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
