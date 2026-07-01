<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserTableController extends Controller
{
    /**
     * Display a listing of the users.
     */
  /**
     * Display a listing of the users (excluding admins).
     */

    public function index(Request $request)
    {
        // Start the query but exclude users with the 'ADMIN' role
        $query = User::where('role', '!=', 'ADMIN');

        // Handle the search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
  if ($request->filled('role')) {
        $query->where('role', $request->role);
    }
        // Paginate the results and append the search query string to pagination links
        $users = $query->orderBy('created_at', 'desc')
                       ->paginate(10)
                       ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user profile.
     */
   /**
     * Display the specified user profile based on their role.
     */
    public function show(User $user)
    {
        $role = strtoupper($user->role);

        // Redirect to the Recruiter profile
        if ($role === 'RECRUITER') {
            return redirect()->route('admin.recruiters.show', $user);
        }

        // Redirect to the Seeker profile
        if ($role === 'SEEKER') {
            return redirect()->route('admin.seeker.show', $user);
        }

    
    }

    /**
     * Suspend the specified user.
     */
    public function suspend(User $user)
    {
        // Prevent an admin from suspending themselves
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success', "User {$user->name} has been suspended.");
    }

    /**
     * Activate the specified user.
     */
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return back()->with('success', "User {$user->name} has been activated.");
    }
}