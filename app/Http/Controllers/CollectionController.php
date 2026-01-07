<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Saree;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::where('is_active', true)
            ->withCount('activeSarees')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('pages.shop-collections', compact('collections'));
    }

    public function show($slug)
    {
        $collection = Collection::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get sarees in this collection
        $query = Saree::where('collection_id', $collection->id)
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with(['collection', 'images']);

        // Sorting
        $sort = request()->get('sort', 'default');
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
        $perPage = request()->get('per_page', 12);
        $sarees = $query->paginate($perPage)->withQueryString();

        return view('pages.shop-collection-detail', compact('collection', 'sarees'));
    }
}