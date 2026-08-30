<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of registered users.
     */
    public function index(Request $request)
    {
        $query = User::withCount('reservations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user = User::findOrFail($id);

        // Prevent admin from removing their own admin role
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot revoke your own administrator privileges.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role for {$user->name} updated to " . ucfirst($request->role) . ".");
    }

    /**
     * Delete user account with safeguard against deleting users with active/existing reservations.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own administrator account while logged in.');
        }

        if ($user->reservations()->exists()) {
            return back()->with('error', "User {$user->name} cannot be deleted because they have associated stay reservation records.");
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User account {$name} deleted successfully.");
    }
}
