<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MangaementAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();

        //add encrypt id
        $users->map(function ($user) {
            $user->encrypted_id = encrypt($user->id);
            return $user;
        });
        $page_name = 'Management Admin';
        $breadcrumbs = [
            ['value' => 'Management Admin', 'url' => ''],
        ];
        return view('dashboard.views.management-admin.index-management-admin', compact('users', 'page_name', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_name = 'Create Admin';
        $breadcrumbs = [
            ['value' => 'Management Admin', 'url' => 'management-admin.index'],
            ['value' => 'Create Admin', 'url' => ''],
        ];
        return view('dashboard.views.management-admin.create-management-admin', compact('page_name', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'nullable|string|max:20|min:9',
            'password' => [
                'required',
                'string',
                Password::min(6)
                    ->mixedCase() // Membutuhkan huruf besar dan kecil
                    ->numbers() // Membutuhkan angka
                    ->symbols() // Membutuhkan simbol
                    ->uncompromised(), // Memeriksa apakah password pernah bocor
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $payload = $request->only('name', 'email', 'phone_number', 'password');
            $payload['password'] = Hash::make($payload['password']);
            $payload['role_id'] = 1;

            User::create($payload);

            return redirect()->route('management-admin.index')->with('success', 'Admin berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
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
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }
            $page_name = 'Edit Admin';
            $breadcrumbs = [
                ['value' => 'Management Admin', 'url' => 'management-admin.index'],
                ['value' => 'Edit Admin', 'url' => ''],
            ];
            return view('dashboard.views.management-admin.edit-management-admin', compact('user', 'page_name', 'breadcrumbs'));
        } catch (\Exception $e) {
            return redirect()->route('management-admin.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20|min:9',
            'password' => [
                'nullable',
                'string',
                Password::min(6)
                    ->mixedCase() // Membutuhkan huruf besar dan kecil
                    ->numbers() // Membutuhkan angka
                    ->symbols() // Membutuhkan simbol
                    ->uncompromised(), // Memeriksa apakah password pernah bocor
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $id = decrypt($id);
            $user = User::find($id);

            if (!$user) {
                throw new \Exception('User not found');
            }
            $payload = $request->only('name', 'email', 'phone_number');
            if ($request->filled('password')) {
                $payload['password'] = Hash::make($request->password);
            }

            User::where('id', $id)->update($payload);

            return redirect()->route('management-admin.index')->with('success', 'Admin berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::find(decrypt($id));
            if (!$user) {
                throw new \Exception('User not found');
            }
            if ($user->role_id == 2) {
                throw new \Exception('Super Admin tidak bisa dihapus');
            }
            //chek apakah sudah punya artikel blog
            $blog = Blog::where('user_id', $user->id)->first();
            if ($blog) {
                throw new \Exception('Admin tidak bisa dihapus karena sudah memiliki artikel blog');
            }
            $user->delete();

            return redirect()->route('management-admin.index')->with('success', 'Admin berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('management-admin.index')->with('error', $e->getMessage());
        }
    }

    public function updateStatus($id) {
        try {
            $id = decrypt($id);
            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }
            if ($user->role_id == 2) {
                throw new \Exception('Super Admin tidak bisa diubah statusnya');
            }
            $user->active = !$user->active;
            $user->save();

            return redirect()->route('management-admin.index')->with('success', 'Status admin berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('management-admin.index')->with('error', $e->getMessage());
        }
    }
}
