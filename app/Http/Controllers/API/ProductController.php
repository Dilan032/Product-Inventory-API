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
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 'error'
            ], 404);
        }
        // Return response
        return response()->json([
            'message' => 'Product retrieved successfully',
            'product' => $product,
            'status' => 'success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Check if product ID is provided
        if (!$id) {
            return response()->json([
                'message' => 'Product ID is required',
                'status' => 'error'
            ], 400);
        }

        // Find the product
        $product = Product::find($id);

        // Check if product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 'error'
            ], 404);
        }
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'quantity' => 'sometimes|required|integer|min:0',
                'category' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|boolean'
            ]);

            // Update product
            $product->update($validatedData);

            // Return response
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
                'status' => 'success'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if product ID is provided
        if (!$id) {
            return response()->json([
                'message' => 'Product ID is required',
                'status' => 'error'
            ], 400);
        }
        
        // Find the product
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 'error'
            ], 404);
        }

        // Delete product
        $product->delete();

        // Return response
        return response()->json([
            'message' => 'Product deleted successfully',
            'status' => 'success'
        ], 200);
    }
}
