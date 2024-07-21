<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = request('role');
        if ($role) {
            if ($role == 'admin') {
                $datas = User::role($role)->where('name', '!=', 'Lazuardi')->get();
            } else {
                $datas = User::role($role)->get();
            }
        } else {
            $datas = User::all();
        }
        return view('pages.user.index', compact('datas', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = request('role');
        return view('pages.user.create',  compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
            'role' => ['required', 'string', 'in:admin,cashier'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $role = $data['role'];
        unset($data['role']);
        unset($data['confirm_password']);
        try {
            $user = User::create($data);
            $user->assignRole($role);
            Alert::success('Success', 'Pengguna berhasil ditambahkan');
            return redirect()->route('users.index', ['role' => $role]);
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,cashier'],
        ]);
        if ($request->password) {
            $request->validate([
                'password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'same:password'],
            ]);
            $data['password'] = Hash::make($request->password);
        }
        $role = $data['role'];
        unset($data['role']);
        try {
            $user->update($data);
            $user->syncRoles($role);
            Alert::success('Success', 'Pengguna berhasil diubah');
            return redirect()->route('users.index', ['role' => $role]);
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $role = $user->roles[0]->name;
            $user->delete();
            Alert::success('Success', 'Pengguna berhasil dihapus');
            return redirect()->route('users.index', ['role' => $role]);
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
