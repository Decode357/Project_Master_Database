<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\{User, Department, Requestor, Customer};

class UserController extends Controller
{
    // 🔹 User Management Controller
    public function user(Request $request)
    {
        $relations = [
            'roles','department', 'requestor', 'customer'
        ];

        // รับค่า perPage จาก request หรือใช้ default 10
        $perPage = $request->get('per_page', 10);
        // จำกัดค่า perPage ที่อนุญาต
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // รับค่า search
        $search = $request->get('search');
        $query = User::with($relations);
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhereHas('roles', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('permissions', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('department', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('requestor', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // ดึง user ทั้งหมดพร้อม roles + paginate
        $users = $query->latest()->paginate($perPage)->appends($request->query());

        $permissions = $this->getUserPermissions();
        $departments = Department::all();
        $requestors = Requestor::all();
        $customers = Customer::all();    
        // เพิ่ม property userPermissions ให้แต่ละ user (ค่อยแก้ให้ users มี roles_id))
        foreach ($users as $user) {
            $user->userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        }

        return view('user', compact('users', 'departments', 'requestors', 'customers', 'perPage', 'search'), $permissions);
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'role'        => 'nullable|string|in:user,admin,superadmin', // เปลี่ยนเป็น nullable
            'permissions' => 'array',
            'department_id' => 'nullable|exists:departments,id',
            'requestor_id'  => 'nullable|exists:requestors,id',
            'customer_id'   => 'nullable|exists:customers,id',
        ]);

        // ถ้าไม่ได้ส่ง role มา ให้ default เป็น 'user'
        $role = $data['role'] ?? 'user';

        // สร้าง user ก่อน
        $user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'department_id' => $data['department_id'] ?? null,
                'requestor_id'  => $data['requestor_id'] ?? null,
                'customer_id'   => $data['customer_id'] ?? null,
            ]);

        // Assign role
        $user->assignRole($role);

        // Sync permissions
        $permissionsToAssign = $data['permissions'] ?? [];
        if (!in_array('view', $permissionsToAssign)) {
            $permissionsToAssign[] = 'view';
        }

        if ($role === 'superadmin') {
            $allPermissions = Permission::pluck('name')->toArray();
            $permissionsToAssign = array_unique(array_merge($permissionsToAssign, $allPermissions));
        }

        $user->syncPermissions($permissionsToAssign);

        return response()->json([
            'status'  => 'success',
            'message' => 'User created successfully!',
            'user'    => $user
        ], 201);
    }



    public function destroyUser(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', // เปลี่ยนเป็น nullable
            'role' => 'required|in:user,admin,superadmin',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'department_id' => 'nullable|exists:departments,id',
            'requestor_id' => 'nullable|exists:requestors,id',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        // อัพเดทข้อมูลพื้นฐาน
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
            'requestor_id' => $data['requestor_id'],
            'customer_id' => $data['customer_id'],
        ];

        // เพิ่ม password เฉพาะเมื่อมีการส่งมา
        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        // อัปเดต role และ permissions
        $user->syncRoles([$data['role']]);

        $permissionsToAssign = $data['permissions'] ?? [];
        if (!in_array('view', $permissionsToAssign)) {
            $permissionsToAssign[] = 'view';
        }

        if ($data['role'] === 'superadmin') {
            $allPermissions = Permission::pluck('name')->toArray();
            $permissionsToAssign = array_unique(array_merge($permissionsToAssign, $allPermissions));
        }

        $user->syncPermissions($permissionsToAssign);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully!',
            'user' => $user->load(['roles', 'department', 'requestor', 'customer'])
        ]);
    }
}

