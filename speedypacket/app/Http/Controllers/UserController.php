<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('directie-users', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        return view('directie-user-create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:directie,koerier,ontvanger,magazijn,backoffice',
            'location' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'location' => $validated['location'],
            'two_factor_enabled' => true,
        ]);

        return redirect()->route('directie.users')->with('success', 'Gebruiker succesvol aangemaakt.');
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $viewedUser = User::findOrFail($id);
        return view('directie-user', compact('viewedUser'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $viewedUser = User::findOrFail($id);
        return view('directie-user-edit', compact('viewedUser'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $viewedUser = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:directie,koerier,ontvanger,magazijn,backoffice',
            'location' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'location' => $validated['location'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $viewedUser->update($updateData);

        return redirect()->route('directie.user', $id)->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'directie') {
            abort(403);
        }

        $viewedUser = User::findOrFail($id);

        // Prevent deleting self
        if ($viewedUser->id === $user->id) {
            return redirect()->route('directie.users')->with('error', 'Je kunt jezelf niet verwijderen.');
        }

        $viewedUser->delete();

        return redirect()->route('directie.users')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
