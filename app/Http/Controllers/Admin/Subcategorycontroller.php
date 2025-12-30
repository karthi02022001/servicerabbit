<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use App\Models\TaskSubcategory;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of subcategories.
     */
    public function index(Request $request)
    {
        $query = TaskSubcategory::with('category')->withCount('services');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
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

        if ($sortBy === 'category') {
            $query->join('task_categories', 'task_subcategories.category_id', '=', 'task_categories.id')
                ->orderBy('task_categories.name', $sortOrder)
                ->select('task_subcategories.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $subcategories = $query->paginate(15);

        // Get categories for filter dropdown
        $categories = TaskCategory::orderBy('name')->get();

        // Stats
        $stats = [
            'total' => TaskSubcategory::count(),
            'active' => TaskSubcategory::where('status', 'active')->count(),
            'featured' => TaskSubcategory::where('is_featured', true)->count(),
            'inactive' => TaskSubcategory::where('status', 'inactive')->count(),
        ];

        return view('admin.subcategories.index', compact('subcategories', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create(Request $request)
    {
        $categories = TaskCategory::active()->ordered()->get();
        $selectedCategoryId = $request->get('category_id');
        $maxSortOrder = TaskSubcategory::max('sort_order') ?? 0;

        return view('admin.subcategories.create', compact('categories', 'selectedCategoryId', 'maxSortOrder'));
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:task_categories,id',
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        // Check unique slug within category
        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $exists = TaskSubcategory::where('category_id', $validated['category_id'])
            ->where('slug', $slug)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['slug' => 'This slug already exists in the selected category.']);
        }

        $validated['slug'] = $slug;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        }

        // Set boolean defaults
        $validated['is_featured'] = $request->boolean('is_featured');

        $subcategory = TaskSubcategory::create($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'create',
            'model_type' => 'TaskSubcategory',
            'model_id' => $subcategory->id,
            'description' => "Created subcategory: {$subcategory->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully!');
    }

    /**
     * Display the specified subcategory.
     */
    public function show(TaskSubcategory $subcategory)
    {
        $subcategory->load('category');
        $subcategory->loadCount('services');

        return view('admin.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit(TaskSubcategory $subcategory)
    {
        $categories = TaskCategory::active()->ordered()->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, TaskSubcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:task_categories,id',
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        // Check unique slug within category (excluding current)
        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $exists = TaskSubcategory::where('category_id', $validated['category_id'])
            ->where('slug', $slug)
            ->where('id', '!=', $subcategory->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['slug' => 'This slug already exists in the selected category.']);
        }

        $validated['slug'] = $slug;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        }

        // Set boolean defaults
        $validated['is_featured'] = $request->boolean('is_featured');

        $subcategory->update($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskSubcategory',
            'model_id' => $subcategory->id,
            'description' => "Updated subcategory: {$subcategory->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(TaskSubcategory $subcategory)
    {
        // Check if subcategory has services
        if ($subcategory->services()->count() > 0) {
            return back()->with('error', 'Cannot delete subcategory with services. Please reassign or delete services first.');
        }

        $subcategoryName = $subcategory->name;

        // Delete image
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
            Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->delete();

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'model_type' => 'TaskSubcategory',
            'model_id' => $subcategory->id,
            'description' => "Deleted subcategory: {$subcategoryName}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully!');
    }

    /**
     * Toggle subcategory status.
     */
    public function toggleStatus(TaskSubcategory $subcategory)
    {
        $subcategory->status = $subcategory->status === 'active' ? 'inactive' : 'active';
        $subcategory->save();

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskSubcategory',
            'model_id' => $subcategory->id,
            'description' => "Toggled subcategory status to {$subcategory->status}: {$subcategory->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', "Subcategory status changed to {$subcategory->status}!");
    }

    /**
     * Toggle subcategory featured status.
     */
    public function toggleFeatured(TaskSubcategory $subcategory)
    {
        $subcategory->is_featured = !$subcategory->is_featured;
        $subcategory->save();

        $status = $subcategory->is_featured ? 'featured' : 'unfeatured';

        // Log activity
        AdminActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'model_type' => 'TaskSubcategory',
            'model_id' => $subcategory->id,
            'description' => "Marked subcategory as {$status}: {$subcategory->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', "Subcategory marked as {$status}!");
    }

    /**
     * Remove subcategory image.
     */
    public function removeImage(TaskSubcategory $subcategory)
    {
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
            Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->update(['image' => null]);

        return back()->with('success', 'Image removed successfully!');
    }

    /**
     * Get subcategories by category (AJAX).
     */
    public function getByCategory(TaskCategory $category)
    {
        $subcategories = $category->subcategories()
            ->active()
            ->ordered()
            ->get(['id', 'name', 'slug']);

        return response()->json($subcategories);
    }
}
