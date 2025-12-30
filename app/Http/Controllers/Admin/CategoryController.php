<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $query = TaskCategory::withCount(['subcategories', 'services']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured == 'yes');
        }

        // Sorting
        $sortBy = $request->get('sort', 'sort_order');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $categories = $query->paginate(15);

        // Stats
        $stats = [
            'total' => TaskCategory::count(),
            'active' => TaskCategory::where('status', 'active')->count(),
            'featured' => TaskCategory::where('is_featured', true)->count(),
            'inactive' => TaskCategory::where('status', 'inactive')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $maxSortOrder = TaskCategory::max('sort_order') ?? 0;
        return view('admin.categories.create', compact('maxSortOrder'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:task_categories,name',
            'slug' => 'nullable|string|max:100|unique:task_categories,slug',
            'description' => 'nullable|string|max:1000',
            'short_description' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'color' => 'nullable|string|max:7',
            'avg_hourly_rate' => 'nullable|numeric|min:0|max:9999.99',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'cancellation_fee_percentage' => 'required|numeric|min:0|max:100',
            'vehicle_required' => 'boolean',
            'background_check_required' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('categories/icons', 'public');
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories/images', 'public');
        }

        // Set boolean defaults
        $validated['vehicle_required'] = $request->boolean('vehicle_required');
        $validated['background_check_required'] = $request->boolean('background_check_required');
        $validated['is_featured'] = $request->boolean('is_featured');

        $category = TaskCategory::create($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'create',
            'model_type' => 'TaskCategory',
            'model_id' => $category->id,
            'description' => "Created category: {$category->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(TaskCategory $category)
    {
        $category->loadCount(['subcategories', 'services', 'bookings']);
        $category->load(['subcategories' => function ($q) {
            $q->ordered()->withCount('services');
        }]);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(TaskCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, TaskCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:task_categories,name,' . $category->id,
            'slug' => 'nullable|string|max:100|unique:task_categories,slug,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'short_description' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'color' => 'nullable|string|max:7',
            'avg_hourly_rate' => 'nullable|numeric|min:0|max:9999.99',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'cancellation_fee_percentage' => 'required|numeric|min:0|max:100',
            'vehicle_required' => 'boolean',
            'background_check_required' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }
            $validated['icon'] = $request->file('icon')->store('categories/icons', 'public');
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories/images', 'public');
        }

        // Set boolean defaults
        $validated['vehicle_required'] = $request->boolean('vehicle_required');
        $validated['background_check_required'] = $request->boolean('background_check_required');
        $validated['is_featured'] = $request->boolean('is_featured');

        $category->update($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskCategory',
            'model_id' => $category->id,
            'description' => "Updated category: {$category->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(TaskCategory $category)
    {
        // Check if category has subcategories or services
        if ($category->subcategories()->count() > 0) {
            return back()->with('error', 'Cannot delete category with subcategories. Please delete subcategories first.');
        }

        if ($category->services()->count() > 0) {
            return back()->with('error', 'Cannot delete category with services. Please reassign or delete services first.');
        }

        $categoryName = $category->name;

        // Delete images
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'model_type' => 'TaskCategory',
            'model_id' => $category->id,
            'description' => "Deleted category: {$categoryName}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(TaskCategory $category)
    {
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskCategory',
            'model_id' => $category->id,
            'description' => "Toggled category status to {$category->status}: {$category->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', "Category status changed to {$category->status}!");
    }

    /**
     * Toggle category featured status.
     */
    public function toggleFeatured(TaskCategory $category)
    {
        $category->is_featured = !$category->is_featured;
        $category->save();

        $status = $category->is_featured ? 'featured' : 'unfeatured';

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskCategory',
            'model_id' => $category->id,
            'description' => "Marked category as {$status}: {$category->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', "Category marked as {$status}!");
    }

    /**
     * Update sort order via AJAX.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:task_categories,id',
            'orders.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->orders as $order) {
            TaskCategory::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated!']);
    }

    /**
     * Remove category icon.
     */
    public function removeIcon(TaskCategory $category)
    {
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->update(['icon' => null]);

        return back()->with('success', 'Icon removed successfully!');
    }

    /**
     * Remove category image.
     */
    public function removeImage(TaskCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->update(['image' => null]);

        return back()->with('success', 'Image removed successfully!');
    }
}
