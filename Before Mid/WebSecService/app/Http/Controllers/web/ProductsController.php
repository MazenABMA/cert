<?php
 namespace App\Http\Controllers\Web;

 use Illuminate\Http\Request;
 use App\Models\Product;
 use Illuminate\Routing\Controller; // Make sure this is the correct base controller
 
 class ProductsController extends Controller
 {
     public function __construct()
     {
         $this->middleware('auth')->except('list'); // Fix middleware usage
     }
 
     public function edit(Request $request, Product $product = null) {
         $product = $product ?? new Product();
         return view("products.add", compact('product'));
     }
 
     public function save(Request $request, Product $product = null)
    {
        // ✅ Use $request->validate(), NOT $this->validate()
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . ($product ? $product->id : 'NULL'),
            'model' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // If updating, keep the existing product; otherwise, create a new one
        $product = $product ?? new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->model = $request->model;
        $product->price = $request->price;
        $product->photo = $request->photo;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }
 
    public function delete(Request $request, Product $product) {
        if (!auth()->user()->hasPermissionTo('delete_products')) {
            abort(401);
        }
        $product->delete();
        return redirect()->route('products_list');
     }
 
     public function list(Request $request) 
     {
         $query = Product::select("products.*");
 
         // Search by keywords
         $query->when($request->keywords, function ($q) use ($request) {
             $q->where("name", "like", "%" . $request->keywords . "%");
         });
 
         // Filter by minimum price
         $query->when($request->min_price, function ($q) use ($request) {
             $q->where("price", ">=", $request->min_price);
         });
 
         // Filter by maximum price
         $query->when($request->max_price, function ($q) use ($request) {
             $q->where("price", "<=", $request->max_price);
         });
 
         // Sort by selected column and direction
         $query->when($request->order_by, function ($q) use ($request) {
             $q->orderBy($request->order_by, $request->order_direction ?? "ASC");
         });
 
         // Fetch the filtered products
         $products = $query->get();
 
         return view("products.list", compact('products'));
     }
 }
 