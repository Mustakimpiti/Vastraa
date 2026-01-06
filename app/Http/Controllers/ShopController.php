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

        // Price range filter - FIXED
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $minPrice = (float) $request->min_price;
            $maxPrice = (float) $request->max_price;
            
            $query->where(function($q) use ($minPrice, $maxPrice) {
                // Check sale_price if it exists and is not null
                $q->where(function($q2) use ($minPrice, $maxPrice) {
                    $q2->whereNotNull('sale_price')
                       ->where('sale_price', '>=', $minPrice)
                       ->where('sale_price', '<=', $maxPrice);
                })
                // Otherwise check regular price
                ->orWhere(function($q2) use ($minPrice, $maxPrice) {
                    $q2->whereNull('sale_price')
                       ->where('price', '>=', $minPrice)
                       ->where('price', '<=', $maxPrice);
                });
            });
        } elseif ($request->filled('min_price')) {
            $minPrice = (float) $request->min_price;
            $query->where(function($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice)
                  ->orWhere(function($q2) use ($minPrice) {
                      $q2->whereNull('sale_price')
                         ->where('price', '>=', $minPrice);
                  });
            });
        } elseif ($request->filled('max_price')) {
            $maxPrice = (float) $request->max_price;
            $query->where(function($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice)
                  ->orWhere(function($q2) use ($maxPrice) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $maxPrice);
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

        // Get distinct filter values
        $fabrics = Saree::where('is_active', true)
            ->whereNotNull('fabric')
            ->where('fabric', '!=', '')
            ->distinct()
            ->pluck('fabric')
            ->filter(function($value) {
                return !empty(trim($value));
            })
            ->sort()
            ->values();

        $occasions = Saree::where('is_active', true)
            ->whereNotNull('occasion')
            ->where('occasion', '!=', '')
            ->distinct()
            ->pluck('occasion')
            ->filter(function($value) {
                return !empty(trim($value));
            })
            ->sort()
            ->values();

        $workTypes = Saree::where('is_active', true)
            ->whereNotNull('work_type')
            ->where('work_type', '!=', '')
            ->distinct()
            ->pluck('work_type')
            ->filter(function($value) {
                return !empty(trim($value));
            })
            ->sort()
            ->values();

        // Price range
        $priceRange = [
            'min' => Saree::where('is_active', true)
                ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price')
                ->value('min_price') ?? 0,
            'max' => Saree::where('is_active', true)
                ->selectRaw('MAX(COALESCE(sale_price, price)) as max_price')
                ->value('max_price') ?? 10000,
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