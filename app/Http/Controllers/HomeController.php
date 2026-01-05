<?php

namespace App\Http\Controllers;

use App\Models\Saree;
use App\Models\Collection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch featured collections for the collection slider
        $featuredCollections = Collection::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Fetch bestseller sarees for the Best Sellers section
        $bestSellers = Saree::where('is_active', true)
            ->where('is_bestseller', true)
            ->where('stock_quantity', '>', 0)
            ->with(['collection', 'images'])
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        // If no bestsellers, get random active sarees
        if ($bestSellers->isEmpty()) {
            $bestSellers = Saree::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->with(['collection', 'images'])
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        // Fetch trending/featured sarees for the trends section
        $trendingSarees = Saree::where('is_active', true)
            ->where('is_featured', true)
            ->where('stock_quantity', '>', 0)
            ->with(['collection', 'images'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // If no featured sarees, get recent sarees
        if ($trendingSarees->isEmpty()) {
            $trendingSarees = Saree::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->with(['collection', 'images'])
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }

        return view('pages.home', compact(
            'featuredCollections',
            'bestSellers',
            'trendingSarees'
        ));
    }
}