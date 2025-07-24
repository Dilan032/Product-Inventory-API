<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Get the Authorization header
        $token = $request->header('Authorization');

        // Optional: log or return token for debugging
        if (!$token) {
            return response()->json([
                'message' => 'No token provided in Authorization header',
                'status' => 'error'
            ], 401);
        }

        // Retrieve all products
        $products = Product::all();

        // Check if products exist
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found',
                'status' => 'error'
            ], 404);
        }
        // Return response
        return response()->json([
            'message' => 'Products retrieved successfully',
            'products' => $products,
            'status' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the Authorization header
        $token = $request->header('Authorization');

        // Optional: log or return token for debugging
        if (!$token) {
            return response()->json([
                'message' => 'No token provided in Authorization header',
                'status' => 'error'
            ], 401);
        }

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'category' => 'required|string|max:255',
                'status' => 'boolean'
            ]);

            // Create product
            $product = Product::create($validatedData);

            // Return response
            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product,
                'status' => 'success'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
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
