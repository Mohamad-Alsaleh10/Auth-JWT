<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json(
            [
                'status' => 'success',
                'Products' =>$products
            ]
        );
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = Products::create(
                [
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'price' => $request->price,
                ]
            );

            DB::commit();
            return response()->json(
                [
                    'status'=>'success',
                    'product' => $product
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json(
                [
                    'status'=>'error',
                    'product' => $product
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {

        return response()->json(
            [
                'status'=>'success',
                'product'=>$product
            ]
            );
    }

    public function update(UpdateProduct $request, Products $product)
    {

        $product->update(
            [
                'name' => $request->name,
                'desc' => $request->desc,
                'price' => $request->price,
            ]
        );

        return response()->json(
            [
                'status'=>'success',
                'product' => $product
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $Product)
    {

        $Product->delete();
        return response()->json(
         [
            'status'=>'success'
         ]
        );

    }
}
