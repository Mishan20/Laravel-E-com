<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $products = Product::paginate();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //save image to disk
        $imagePath =$request->file('image')->store('products', 'public');
        $request->validate([
            'p_id' => 'required|unique:products',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = new Product();

        $product->p_id        = $request->p_id;
        $product->name        = $request->name;
        $product->qty         = $request->qty;
        $product->price       = $request->price;
        $product->status      = 1;
        $product->category_id = $request->category_id;
        $product->seller_id   = auth()->user()->id;
        $product->image       = $imagePath;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return view('products.show' , compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'p_id' => 'required|unique:products,p_id,' . $id,
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        $product = Product::find($id);

        $product->p_id = $request->p_id;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();


        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
