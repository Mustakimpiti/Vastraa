<?php

namespace App\Http\Controllers;

use App\Models\Saree;
use App\Models\Collection;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Start with base query
        $query = Saree::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with(['collection', 'images']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('fabric', 'like', "%{$search}%")
                  ->orWhere('occasion', 'like', "%{$search}%");
            });
        }

        // Filter by collection
        if ($request->filled('collection')) {
            $query->where('collection_id', $request->collection);
        }

        // Filter by fabric
        if ($request->filled('fabric')) {
            $query->where('fabric', $request->fabric);
        }

        // Filter by occasion
        if ($request->filled('occasion')) {
            $query->where('occasion', $request->occasion);
        }

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '>=', $request->min_price);
                  });
            });
        }

        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->max_price);
                  });
            });
        }

        // Filter by features
        if ($request->filled('featured')) {
            if ($request->featured === 'new') {
                $query->where('is_new_arrival', true);
            } elseif ($request->featured === 'bestseller') {
                $query->where('is_bestseller', true);
            } elseif ($request->featured === 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('avg_rating', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $sarees = $query->paginate($perPage)->withQueryString();

        // Get filter data
        $collections = Collection::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Fixed: Properly filter and ensure we return collections
        $fabrics = Saree::where('is_active', true)
            ->whereNotNull('fabric')
            ->where('fabric', '!=', '')
            ->distinct()
            ->pluck('fabric')
            ->filter(function($value) {
                return !empty($value);
            })
            ->sort()
            ->values();

        $occasions = Saree::where('is_active', true)
            ->whereNotNull('occasion')
            ->where('occasion', '!=', '')
            ->distinct()
            ->pluck('occasion')
            ->filter(function($value) {
                return !empty($value);
            })
            ->sort()
            ->values();

        $workTypes = Saree::where('is_active', true)
            ->whereNotNull('work_type')
            ->where('work_type', '!=', '')
            ->distinct()
            ->pluck('work_type')
            ->filter(function($value) {
                return !empty($value);
            })
            ->sort()
            ->values();

        // Price range
        $priceRange = [
            'min' => Saree::where('is_active', true)->min('price') ?? 0,
            'max' => Saree::where('is_active', true)->max('price') ?? 10000,
        ];

        return view('pages.shop', compact(
            'sarees',
            'collections',
            'fabrics',
            'occasions',
            'workTypes',
            'priceRange'
        ));
    }
}