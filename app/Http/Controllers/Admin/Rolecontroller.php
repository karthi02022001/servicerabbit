<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(): View
    {
        $roles = Role::withCount(['admins', 'permissions'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permission::getGrouped();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_default' => ['boolean'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name'], '_');

        // If this role is set as default, remove default from others
        if ($request->boolean('is_default')) {
            Role::where('is_default', true)->update(['is_default' => false]);
        }

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'is_default' => $request->boolean('is_default'),
        ]);

        // Attach permissions
        $role->permissions()->attach($validated['permissions']);

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'create',
            Role::class,
            $role->id,
            "Created role: {$role->name}"
        );

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing the role.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::getGrouped();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
            'is_default' => ['boolean'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        // Store old values for logging
        $oldValues = $role->toArray();

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name'], '_');

        // If this role is set as default, remove default from others
        if ($request->boolean('is_default') && !$role->is_default) {
            Role::where('is_default', true)->update(['is_default' => false]);
        }

        $role->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'is_default' => $request->boolean('is_default'),
        ]);

        // Sync permissions
        $role->permissions()->sync($validated['permissions']);

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'update',
            Role::class,
            $role->id,
            "Updated role: {$role->name}",
            $oldValues,
            $role->fresh()->toArray()
        );

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Prevent deletion of super_admin role
        if ($role->slug === 'super_admin') {
            return back()->with('error', 'Cannot delete the Super Admin role.');
        }

        // Check if role has admins
        if ($role->admins()->count() > 0) {
            return back()->with('error', 'Cannot delete role that has assigned admins. Please reassign them first.');
        }

        $roleName = $role->name;

        // Detach all permissions
        $role->permissions()->detach();

        // Delete role
        $role->delete();

        // Log activity
        AdminActivityLog::log(
            Auth::guard('admin')->id(),
            'delete',
            Role::class,
            null,
            "Deleted role: {$roleName}"
        );

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }
}
