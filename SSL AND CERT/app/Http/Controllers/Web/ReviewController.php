<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Product $product)
    {
        // Check if user has permission to add review
        if(!auth()->user()->hasPermissionTo('add_review')) {
            abort(403, 'You do not have permission to add reviews.');
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        // Check if user has permission to add review
        if(!auth()->user()->hasPermissionTo('add_review')) {
            abort(403, 'You do not have permission to add reviews.');
        }

        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Create the review
        $review = new Review([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $review->save();

        return redirect()->route('products_list')
            ->with('success', 'Review added successfully!');
    }

    /**
     * Display a listing of reviews for a product.
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with('user')->latest()->get();
        
        return view('reviews.index', compact('product', 'reviews'));
    }
}
