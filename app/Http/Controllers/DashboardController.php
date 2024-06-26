<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Trait\SMS_Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use SMS_Notification;
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $products = Product::where('name', 'like', "%$query%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })->get();
        } else {
            $products = Product::all();
        }

        $categories = Category::with('products')->get();
        
        return view('dashboard', compact('categories', 'products', 'query'));
    }
}
