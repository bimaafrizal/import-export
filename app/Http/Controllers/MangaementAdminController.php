<?php

namespace App\Http\Controllers;

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
        return view('dashboard.views.management-admin.index-management-admin', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.views.management-admin.create-management-admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|string|max:20|min:9',
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

            return redirect()->route('management-admin.index');
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
