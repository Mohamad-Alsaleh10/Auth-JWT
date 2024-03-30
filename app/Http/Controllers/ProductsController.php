<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Products::create($validatedData);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'desc' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $products->update($validatedData);

        return response()->json($products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $product = Products::find($id);
        if ($product) {
            $product->delete();
            return response()->json('success delete ');
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }

    }
}
