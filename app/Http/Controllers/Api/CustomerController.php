<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;    

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::all());
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'email' => 'nullable|email',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'note' => 'nullable|string',
            'address' => 'nullable|string',
            'hometown' => 'nullable|string',
            'customer_type' => 'in:regular,vip,new',
        ]);

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }
}
