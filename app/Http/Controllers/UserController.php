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
    public function user()
    {
        // ดึง user ทั้งหมดพร้อม roles + paginate
        $users = User::with(['roles','department', 'requestor', 'customer'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        // สีแต่ละ permission
        $permissionColors = [
            'view' => 'bg-yellow-100 text-yellow-800',
            'edit' => 'bg-blue-100 text-blue-800',
            'delete' => 'bg-red-100 text-red-800',
            'create' => 'bg-green-100 text-green-800',
            'file import' => 'bg-gray-100 text-gray-800',
            'manage users' => 'bg-purple-100 text-purple-800',
        ];

        $departments = Department::all();
        $requestors = Requestor::all();
        $customers = Customer::all();    
        // เพิ่ม property userPermissions ให้แต่ละ user (ค่อยแก้ให้ users มี roles_id))
        foreach ($users as $user) {
            $user->userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        }

        return view('user', compact('users', 'departments', 'requestors', 'customers', 'permissionColors'));
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

        return redirect()->route('user')->with('success', 'User deleted successfully.');
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
            'success' => 'User updated successfully.',
            'user' => $user->load(['roles', 'department', 'requestor', 'customer'])
        ]);
    }
}

