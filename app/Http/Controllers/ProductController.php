<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Retrive the product from the database using the provided $id
        $product = Product::find($id);

        // Check if the product found
        if ($product) {
            // Return the product as a JSON response with a 200 HTTP status code
            return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product Not Found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        // Check if the product was found
        if ($product) {
            // Update the product with the validated data
            $product->update($validatedData);

            // Return the updated product as a JSON response with a 200 HTTP status code
            return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product Not Found'], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //Check if the product was found
        if ($product) {
            // Delete the product
            $product->delete();

            // Return a 204 No Content HTTP status code
            return response()->json(null, 204);
        } else {
            // return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product Not Found'], 404);
        }
    }
}
