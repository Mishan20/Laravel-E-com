<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Rules\CheckString;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            return $this->sendResponse($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('An error occurred while retrieving products.', [$e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'p_id' => 'required|unique:products',
        //     'name' => ['required', new CheckString],
        //     'qty' => 'required',
        //     'price' => 'required',
        //     'category_id' => 'required',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // if ($request->hasFile('image')) {

        //     $image = $request->file('image');
        //     $filename = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $filename);
        //     $path = 'images/' . $filename;
        //     $product = new Product();
        //     $product->p_id = $request->p_id;
        //     $product->name = $request->name;
        //     $product->qty = $request->qty;
        //     $product->price = $request->price;
        //     $product->status = 1;
        //     $product->category_id = $request->category_id;
        //     $product->seller_id = auth()->user()->id;
        //     $product->image = $path;
        //     $product->save();
        // }

        $product = new Product();

        $product->p_id = $request->p_id;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->image = NULL;
        $product->category_id = $request->category_id;
        $product->seller_id = $request->seller_id;
        $product->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'p_id' => 'required|unique:products,p_id,' . $id,
        //     'name' => 'required',
        //     'qty' => 'required',
        //     'price' => 'required',
        //     'category_id' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // $product = Product::find($id);
        // $product->p_id = $request->p_id;
        // $product->name = $request->name;
        // $product->qty = $request->qty;
        // $product->price = $request->price;
        // $product->status = 1;
        // $product->category_id = $request->category_id;
        // $product->seller_id = auth()->user()->id;
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $filename = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $filename);
        //     $path = 'images/' . $filename;
        //     $product->image = $path;
        // }
        // $product->save();

        $product = Product::find($id);

        $product->p_id = $request->p_id;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->image = NULL;
        $product->category_id = $request->category_id;
        $product->seller_id = $request->seller_id;
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
