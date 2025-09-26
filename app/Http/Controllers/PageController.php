<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shape;
use App\Models\Pattern;
use App\Models\Backstamp;
use App\Models\Glaze;
use App\Models\Color;
use App\Models\Effect;
use App\Models\Department;
use App\Models\Requestor;
use App\Models\Customer;

class PageController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function shapeindex()
    {
        // ดึงข้อมูลจาก DB ทั้งหมด
        $shapes = Shape::orderBy('id', 'desc')->paginate(10);
        return view('shape', compact('shapes'));
    }

    public function patternindex()
    {
        $patterns = Pattern::orderBy('id', 'desc')->paginate(10);
        return view('pattern', compact('patterns'));
    }


    public function backstampindex() {
        $backstamps = Backstamp::orderBy('id', 'desc')->paginate(10);
        return view('backstamp', compact('backstamps'));
    }
    
    public function glazeindex() {        
        $glazes = Glaze::orderBy('id', 'desc')->paginate(10);
        return view('glaze',compact('glazes'));
    }

    public function colorindex() {
        $colors = Color::orderBy('id', 'desc')->paginate(10);
        return view('color',compact('colors'));
    }

public function effectindex()
{
    // Eager load colors เพื่อลด query และ join pivot table
    $effects = Effect::with('colors')
                     ->orderBy('id', 'asc')
                     ->paginate(10);

    return view('effect', compact('effects'));
}


    // 🔹 User Management Controller
    public function user()
    {
        // ดึง user ทั้งหมดพร้อม roles + paginate
        $users = User::with(['roles','department', 'requestor', 'customer'])
            ->orderBy('id', 'asc')
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
        'role'        => 'required|string|in:user,admin,superadmin',
        'permissions' => 'array',
        'department_id' => 'nullable|exists:departments,id',
        'requestor_id'  => 'nullable|exists:requestors,id',
        'customer_id'   => 'nullable|exists:customers,id',
    ]);

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
    $user->assignRole($data['role']);

    // Sync permissions
    $permissionsToAssign = $data['permissions'] ?? [];
    if (!in_array('view', $permissionsToAssign)) {
        $permissionsToAssign[] = 'view';
    }

    if ($data['role'] === 'superadmin') {
        $allPermissions = Permission::pluck('name')->toArray();
        $permissionsToAssign = array_unique(array_merge($permissionsToAssign, $allPermissions));
    }

    $user->syncPermissions($permissionsToAssign);

    return redirect()->back()->with('success', 'User created successfully!');
}



    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('user')->with('success', 'User deleted successfully.');
    }

public function updateUser(Request $request, User $user)
{
    $data = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255',
        'password'      => 'nullable|string|min:8',
        'role'          => 'required|string|in:user,admin,superadmin',
        'permissions'   => 'nullable|array',
        'department_id' => 'nullable|exists:departments,id',
        'requestor_id'  => 'nullable|exists:requestors,id',
        'customer_id'   => 'nullable|exists:customers,id',
    ]);

    // อัปเดตข้อมูลพื้นฐาน
    $user->name          = $data['name'];
    $user->email         = $data['email'];
    $user->department_id = $data['department_id'] ?? null;
    $user->requestor_id  = $data['requestor_id'] ?? null;
    $user->customer_id   = $data['customer_id'] ?? null;

    // ถ้ามี password ใหม่ ให้ hash
    if (!empty($data['password'])) {
        $user->password = bcrypt($data['password']);
    }

    $user->save();

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

    return redirect()->back()->with('success', 'User updated successfully!');
}




    public function csvImport() {
        return view('csvImport');
    }
}
