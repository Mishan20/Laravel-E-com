<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Trait\SMS_Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use SMS_Notification;

    public function addToCart(Product $product)
    {
        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // If the product is already in the cart, increase the quantity
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // If the product is not in the cart, add it
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image(),
            ]);

            Log::channel('cart-action')->info('Product added to cart: ' . $product->name . '  User: "' . Auth::user()->name);
            // Send SMS
            // $this->sendSMS($product->name, $product->price);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->get();
        $total = $cart->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('cart', compact('cart', 'total'));
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id == Auth::id()) {
            if ($request->operation === 'increase') {
                $cartItem->quantity++;
            } elseif ($request->operation === 'decrease') {
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity--;
                } else {
                    $cartItem->delete();
                }
            }
            $cartItem->save();
        }

        return redirect()->back();
    }

    public function remove($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->back();
    }
}