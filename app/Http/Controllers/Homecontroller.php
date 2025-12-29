<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\TaskCategory;
use App\Models\TaskerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        // Get featured categories (also aliased as $categories for blade compatibility)
        $featuredCategories = TaskCategory::where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        // Alias for blade templates that use $categories
        $categories = $featuredCategories;

        // Get all active categories
        $allCategories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // Get featured taskers
        $featuredTaskers = User::where('is_tasker', true)
            ->where('is_active', true)
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved')
                    ->where('is_available', true)
                    ->where('is_featured', true);
            })
            ->with(['taskerProfile'])
            ->take(4)
            ->get();

        // If no featured taskers, get top rated taskers
        if ($featuredTaskers->isEmpty()) {
            $featuredTaskers = User::where('is_tasker', true)
                ->where('is_active', true)
                ->whereHas('taskerProfile', function ($query) {
                    $query->where('verification_status', 'approved')
                        ->where('is_available', true)
                        ->where('average_rating', '>=', 4);
                })
                ->with(['taskerProfile'])
                ->take(4)
                ->get();
        }

        // Alias for blade templates that use $taskers
        $taskers = $featuredTaskers;

        // Get statistics - include ALL keys the view might expect
        $stats = [
            // User stats
            'total_users' => User::count(),
            'happy_customers' => User::where('is_tasker', false)->count(),

            // Tasker stats
            'total_taskers' => TaskerProfile::where('verification_status', 'approved')->count(),
            'active_taskers' => TaskerProfile::where('verification_status', 'approved')
                ->where('is_available', true)
                ->count(),

            // Category stats
            'total_categories' => TaskCategory::where('status', 'active')->count(),

            // Booking stats
            'total_bookings' => Booking::count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'tasks_completed' => Booking::where('status', 'completed')->count(),

            // Review stats
            'total_reviews' => Review::where('status', 'approved')->count(),
            'average_rating' => Review::where('status', 'approved')->avg('rating') ?? 5.0,

            // Additional common stats
            'satisfaction_rate' => 98,
            'years_in_business' => 5,
        ];

        return view('home', compact(
            'categories',
            'featuredCategories',
            'allCategories',
            'taskers',
            'featuredTaskers',
            'stats'
        ));
    }

    /**
     * Handle search requests.
     */
    public function search(Request $request): View
    {
        $query = $request->get('q');
        $categorySlug = $request->get('category');

        // Get all active categories for the dropdown
        $allCategories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $categories = $allCategories;

        // Build taskers query
        $taskersQuery = User::where('is_tasker', true)
            ->where('is_active', true)
            ->whereHas('taskerProfile', function ($q) {
                $q->where('verification_status', 'approved')
                    ->where('is_available', true);
            })
            ->with(['taskerProfile', 'taskerProfile.services', 'taskerProfile.services.category']);

        // Filter by search query
        if ($query) {
            $taskersQuery->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%")
                    ->orWhereHas('taskerProfile', function ($q2) use ($query) {
                        $q2->where('headline', 'like', "%{$query}%")
                            ->orWhere('bio', 'like', "%{$query}%");
                    })
                    ->orWhereHas('taskerProfile.services', function ($q2) use ($query) {
                        $q2->where('title', 'like', "%{$query}%");
                    });
            });
        }

        // Filter by category
        if ($categorySlug) {
            $category = TaskCategory::where('slug', $categorySlug)->first();
            if ($category) {
                $taskersQuery->whereHas('taskerProfile.services', function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                });
            }
        }

        // Order by rating
        $taskers = $taskersQuery
            ->orderByDesc(function ($q) {
                $q->select('average_rating')
                    ->from('tasker_profiles')
                    ->whereColumn('tasker_profiles.user_id', 'users.id')
                    ->limit(1);
            })
            ->paginate(12);

        return view('search.index', compact(
            'taskers',
            'categories',
            'allCategories',
            'query',
            'categorySlug'
        ));
    }

    /**
     * Show all categories.
     */
    public function categories(): View
    {
        $categories = TaskCategory::where('status', 'active')
            ->withCount(['services' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show a single category with its taskers.
     */
    public function category(string $slug): View
    {
        $category = TaskCategory::where('slug', $slug)
            ->where('status', 'active')
            ->with(['subcategories' => function ($query) {
                $query->where('status', 'active')->orderBy('sort_order');
            }])
            ->firstOrFail();

        $taskers = User::where('is_tasker', true)
            ->where('is_active', true)
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved')
                    ->where('is_available', true);
            })
            ->whereHas('taskerProfile.services', function ($query) use ($category) {
                $query->where('category_id', $category->id)
                    ->where('is_active', true);
            })
            ->with(['taskerProfile', 'taskerProfile.services' => function ($query) use ($category) {
                $query->where('category_id', $category->id)->where('is_active', true);
            }])
            ->paginate(12);

        return view('categories.show', compact('category', 'taskers'));
    }

    /**
     * Show all taskers.
     */
    public function taskers(Request $request): View
    {
        $allCategories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $taskersQuery = User::where('is_tasker', true)
            ->where('is_active', true)
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved')
                    ->where('is_available', true);
            })
            ->with(['taskerProfile', 'taskerProfile.services.category']);

        // Apply filters
        if ($request->filled('category')) {
            $taskersQuery->whereHas('taskerProfile.services.category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if ($request->filled('min_price')) {
            $taskersQuery->whereHas('taskerProfile', function ($query) use ($request) {
                $query->where('hourly_rate', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $taskersQuery->whereHas('taskerProfile', function ($query) use ($request) {
                $query->where('hourly_rate', '<=', $request->max_price);
            });
        }

        if ($request->filled('min_rating')) {
            $taskersQuery->whereHas('taskerProfile', function ($query) use ($request) {
                $query->where('average_rating', '>=', $request->min_rating);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'rating');
        switch ($sortBy) {
            case 'price_low':
                $taskersQuery->orderBy(function ($query) {
                    $query->select('hourly_rate')
                        ->from('tasker_profiles')
                        ->whereColumn('tasker_profiles.user_id', 'users.id')
                        ->limit(1);
                });
                break;
            case 'price_high':
                $taskersQuery->orderByDesc(function ($query) {
                    $query->select('hourly_rate')
                        ->from('tasker_profiles')
                        ->whereColumn('tasker_profiles.user_id', 'users.id')
                        ->limit(1);
                });
                break;
            case 'reviews':
                $taskersQuery->orderByDesc(function ($query) {
                    $query->select('total_reviews')
                        ->from('tasker_profiles')
                        ->whereColumn('tasker_profiles.user_id', 'users.id')
                        ->limit(1);
                });
                break;
            case 'rating':
            default:
                $taskersQuery->orderByDesc(function ($query) {
                    $query->select('average_rating')
                        ->from('tasker_profiles')
                        ->whereColumn('tasker_profiles.user_id', 'users.id')
                        ->limit(1);
                });
                break;
        }

        $taskers = $taskersQuery->paginate(12);

        return view('taskers.index', compact('taskers', 'allCategories'));
    }

    /**
     * Show a single tasker profile.
     */
    public function tasker(int $id): View
    {
        $tasker = User::where('id', $id)
            ->where('is_tasker', true)
            ->where('is_active', true)
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->with([
                'taskerProfile',
                'taskerProfile.services.category',
                'taskerProfile.services.subcategory',
                'reviewsReceived' => function ($query) {
                    $query->where('status', 'approved')
                        ->orderByDesc('created_at')
                        ->take(10);
                },
                'reviewsReceived.reviewer',
            ])
            ->firstOrFail();

        // Get similar taskers
        $similarTaskers = User::where('is_tasker', true)
            ->where('is_active', true)
            ->where('id', '!=', $id)
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved')
                    ->where('is_available', true);
            })
            ->with(['taskerProfile'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('taskers.show', compact('tasker', 'similarTaskers'));
    }
}
