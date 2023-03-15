<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), 
        [
            'user_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'total' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $tax = $request->price * 0.10;
        $admin_fee = $request->price * 0.05 + $tax;
        $product = Transaction::create([
            'id' => Str::uuid(),
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'admin_fee' => $admin_fee,
            'tax' => $tax,
            'total' =>  $request->total
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product Created Successfully',
            'data' => $product
        ], 200);
    }

    public function getList(Request $request)
    {
        return response()->json([
            'transactions' => Transaction::all()
        ], 200);
    }

    public function getDetail(Request $request)
    {
        return response()->json([
            'transactions' => Transaction::where('id', $request->id)->get()
        ], 200);
    }
}
