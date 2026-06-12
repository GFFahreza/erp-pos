<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {
        return view('Manajemen Karyawan.index');
    }

    public function list(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', '');

        $query = \App\Models\Employee::query();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($role !== '') {
            $query->where('role', $role);
        }

        return response()->json([
            'data' => $query->orderBy('created_at', 'desc')->limit(200)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'nik' => 'required|string|max:120|unique:employees,nik',
            'email' => 'required|email|max:190|unique:employees,email',
            'role' => 'required|string|in:cashier,admin,manager',
            'status' => 'required|string|in:active,inactive',
            'pin' => 'required|string|min:4|max:12',
        ]);

        $employee = \App\Models\Employee::create([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
            'pin_hash' => \Illuminate\Support\Facades\Hash::make($data['pin']),
            'pin_set' => true,
        ]);

        return response()->json(['ok' => true, 'data' => $employee]);
    }

    public function update(Request $request, $id)
    {
        $employee = \App\Models\Employee::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'nik' => 'required|string|max:120|unique:employees,nik,' . $employee->id,
            'email' => 'required|email|max:190|unique:employees,email,' . $employee->id,
            'role' => 'required|string|in:cashier,admin,manager',
            'status' => 'required|string|in:active,inactive',
            'pin' => 'required|string|min:4|max:12',
        ]);

        $employee->update([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
            'pin_hash' => \Illuminate\Support\Facades\Hash::make($data['pin']),
            'pin_set' => true,
        ]);

        return response()->json(['ok' => true, 'data' => $employee]);
    }
}

