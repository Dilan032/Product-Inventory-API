<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    public function register(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8'
            ]);

            // Create user
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]);

            // Return response
            return response()->json([
                'message' => 'User registered successfully',
                'status' => 'success'
            ], 201);

        } catch (ValidationException $e) {
            // Validation errors
            return response()->json([
                'message' => 'Validation failed, please check your input',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration, try again later',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid Email or Password',
                    'status' => 'error'
                ], 401);
            }

            // Create token
            $token = $user->createToken('API Token')->plainTextToken;

            // Return response
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'status' => 'success'
            ], 200);


        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed, please check your input',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login, try again later',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }


}
