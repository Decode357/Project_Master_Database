<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function customerindex(Request $request)
    {
        // รับค่า perPage จาก request หรือใช้ default 10
        $perPage = $request->get('per_page', 10);
        // จำกัดค่า perPage ที่อนุญาต
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // รับค่า search
        $search = $request->get('search');
        $query = Customer::query();
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('code', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        $customers = $query->latest()->paginate($perPage)->appends($request->query());


        $permissions = $this->getUserPermissions();

        return view('customer', compact('customers', 'perPage', 'search'), $permissions);
    }





    private function rules($id = null)
    {
        return [
            'code' => [
                'required', 'string', 'max:255',
                Rule::unique('customers', 'code')->ignore($id),
            ],
            'name' => [
                'nullable', 'string', 'max:255',
            ],
            'email' => [
                'nullable', 'string', 'email', 'max:255',
            ],
            'phone' => [
                'nullable', 'string', 'max:50',
            ],
        ];
    }

    private function messages()
    {
        return [
            'code.required' => __('controller.validation.customer_code.required'),
            'code.unique' => __('controller.validation.customer_code.unique'),
            'code.max' => __('controller.validation.customer_code.max'),
            'name.max' => __('controller.validation.customer_name.max'),
            'email.email' => __('controller.validation.customer_email.email'),
            'email.max' => __('controller.validation.customer_email.max'),
            'phone.max' => __('controller.validation.customer_phone.max'),
        ];
    }

    public function storeCustomer(Request $request)
    { 
        $data = $request->validate($this->rules(), $this->messages());

        $customer = Customer::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);
        
        return response()->json([
            'status'  => 'success',
            'message' => __('controller.customer.created'),
            'customer'  => $customer
        ], 201);
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $data = $request->validate($this->rules($customer->id), $this->messages());

        $customer->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => __('controller.customer.updated'),
            'customer'  => $customer
        ], 200);
    }

    public function destroyCustomer(Customer $customer)
    {
        $customer->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('controller.customer.deleted')
        ]);
    }
}
