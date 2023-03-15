<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), 
        [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $product = Product::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'is_active' => 1,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product Created Successfully',
            'data' => $product
        ], 200);
    }
    
    public function update(Request $request)
    {
        // return $request;
        $validate = Validator::make($request->all(), 
        [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $product = Product::where('id', $request->id)->update([
            'id' => Str::uuid(),
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product updated Successfully'
        ], 200);
    }

    public function delete($id, Request $request)
    {
        $product = Product::where('id',$id)->update([
            "is_active" => 2
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product deleted Successfully'
        ], 200);
    }

    public function getList(Request $request)
    {
        return response()->json([
            'products' => Product::where('is_active', 1)->get()
        ], 200);
    }

    public function getDetail($id)
    {
        return response()->json([
            'product' => Product::where('id', $id)->where('is_active', 1)->first()
        ], 200);
    }

}
