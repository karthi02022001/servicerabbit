<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivityLog;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index(Request $request): View
    {
        $query = Admin::with('roles')
            ->withCount('activityLogs');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('roles.id', $request->role);
            });
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::orderBy('name')->get();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:admins,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('admin-avatars', 'public');
        }

        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'avatar' => $avatarPath,
            'is_active' => $request->boolean('is_active', true),
            'is_super_admin' => false,
        ]);

        // Attach roles
        $admin->roles()->attach($validated['roles']);

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'create',
            Admin::class,
            $admin->id,
            "Created admin: {$admin->full_name}"
        );

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully!');
    }

    /**
     * Display the specified admin.
     */
    public function show(Admin $admin): View
    {
        $admin->load('roles.permissions');

        $recentActivity = AdminActivityLog::where('admin_id', $admin->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.admins.show', compact('admin', 'recentActivity'));
    }

    /**
     * Show the form for editing the admin.
     */
    public function edit(Admin $admin): View
    {
        // Prevent editing super admin by non-super admin
        if ($admin->is_super_admin && !Auth::guard('admin')->user()->is_super_admin) {
            abort(403, 'You cannot edit super admin accounts.');
        }

        $roles = Role::orderBy('name')->get();
        $adminRoles = $admin->roles->pluck('id')->toArray();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRoles'));
    }

    /**
     * Update the specified admin.
     */
    public function update(Request $request, Admin $admin): RedirectResponse
    {
        // Prevent editing super admin by non-super admin
        if ($admin->is_super_admin && !Auth::guard('admin')->user()->is_super_admin) {
            return back()->with('error', 'You cannot edit super admin accounts.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:admins,email,' . $admin->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Store old values for logging
        $oldValues = $admin->toArray();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('admin-avatars', 'public');
        }

        // Update admin
        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        if (isset($validated['avatar'])) {
            $updateData['avatar'] = $validated['avatar'];
        }

        $admin->update($updateData);

        // Sync roles (but don't change roles for super admin)
        if (!$admin->is_super_admin) {
            $admin->roles()->sync($validated['roles']);
        }

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'update',
            Admin::class,
            $admin->id,
            "Updated admin: {$admin->full_name}",
            $oldValues,
            $admin->fresh()->toArray()
        );

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully!');
    }

    /**
     * Toggle admin active status.
     */
    public function toggleStatus(Admin $admin): RedirectResponse
    {
        // Prevent deactivating yourself
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        // Prevent deactivating super admin
        if ($admin->is_super_admin) {
            return back()->with('error', 'You cannot deactivate super admin accounts.');
        }

        $admin->update([
            'is_active' => !$admin->is_active,
        ]);

        $action = $admin->is_active ? 'activate' : 'deactivate';

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            $action,
            Admin::class,
            $admin->id,
            ucfirst($action) . "d admin: {$admin->full_name}"
        );

        return back()->with('success', 'Admin ' . ($admin->is_active ? 'activated' : 'deactivated') . ' successfully!');
    }

    /**
     * Remove the specified admin.
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        // Prevent deleting yourself
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting super admin
        if ($admin->is_super_admin) {
            return back()->with('error', 'You cannot delete super admin accounts.');
        }

        $adminName = $admin->full_name;

        // Delete avatar if exists
        if ($admin->avatar) {
            Storage::disk('public')->delete($admin->avatar);
        }

        // Detach roles
        $admin->roles()->detach();

        // Soft delete admin
        $admin->delete();

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'delete',
            Admin::class,
            null,
            "Deleted admin: {$adminName}"
        );

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully!');
    }

    /**
     * Remove avatar.
     */
    public function removeAvatar(Admin $admin): RedirectResponse
    {
        if ($admin->avatar) {
            Storage::disk('public')->delete($admin->avatar);
            $admin->update(['avatar' => null]);
        }

        return back()->with('success', 'Avatar removed successfully!');
    }
}
    