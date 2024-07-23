<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestFakeApiController extends Controller
{
    public function index(){
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();

        // Group products by category
        $groupedProducts = collect($products)->groupBy('category');

        return view('fake-product-list', ['groupedProducts' => $groupedProducts]);
    }
}