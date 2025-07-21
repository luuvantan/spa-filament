<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;    
use App\Helpers\ApiResponse;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();

        return ApiResponse::success($customer);
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

        return ApiResponse::success($customer, 'Tạo mới thành công', 201);
    }

    public function show(Customer $customer)
    {
        return ApiResponse::success($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers,phone,' . $customer->id,
            'email' => 'nullable|email',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'note' => 'nullable|string',
            'address' => 'nullable|string',
            'hometown' => 'nullable|string',
            'customer_type' => 'in:regular,vip,new',
        ]);

        $customer->update($data);

        return ApiResponse::success($customer, 'Cập nhật thành công', 201);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return ApiResponse::success(null, 'Xóa thành công', 201);
    }
}
