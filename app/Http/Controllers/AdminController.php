<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.admin', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'login' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'full_name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно обновлен'
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно удален'
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Пароль успешно изменен'
        ]);
    }
}
