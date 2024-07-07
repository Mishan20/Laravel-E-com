<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Rules\CheckString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $products = Product::paginate();
        } elseif (Auth::user()->hasRole('seller')) {
            $products = Product::where('seller_id', '=', Auth::id())->paginate();
        }
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
        $request->validate([
            'p_id' => 'required|unique:products',
            'name' => ['required', new CheckString],
            'qty' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Save image to disk
            $imagePath = $request->file('image')->store('products', 'public');

            $product = new Product();
            $product->p_id = $request->p_id;
            $product->name = $request->name;
            $product->qty = $request->qty;
            $product->price = $request->price;
            $product->status = 1;
            $product->category_id = $request->category_id;
            $product->seller_id = auth()->user()->id;
            $product->image = $imagePath;
            $product->save();

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } else {
            return redirect()->back()->withErrors(['image' => 'Image upload failed.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('products.edit', compact('product', 'categories'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::find($id);

        $product->p_id = $request->p_id;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Save new image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

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

    public function deleteImage(string $id)
    {
        $product = Product::find($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
            $product->image = null;
            $product->save();
        }

        return redirect()->route('products.edit', $product->id)->with('success', 'Product image deleted successfully');
    }
}
