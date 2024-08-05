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
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // If the product is already in the cart, increase the quantity
            $cart[$product->id]['quantity']++;

            // Update the cart item in the database
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();
            if ($cartItem) {
                $cartItem->quantity = $cart[$product->id]['quantity'];
                $cartItem->save();
            }
        } else {
            // If the product is not in the cart, add it
            $cart[$product->id] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image(),
            ];

            // Create a new cart item in the database
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image(),
            ]);

            Log::channel('cart-action')->info('Product added to cart' . $product->name . '  User"' . Auth::user()->name);
            // Send SMS
            // $this->sendSMS($product->name, $product->price);
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $key => $item) {
            // Calculate item total
            $itemTotal = $item['quantity'] * $item['price'];
            $cart[$key]['itemTotal'] = $itemTotal; // Add item total to each item in the cart
            $total += $itemTotal; // Accumulate total
        }

        return view('cart', compact('cart', 'total'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if ($request->operation === 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($request->operation === 'decrease') {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
        }

        // Update the cart item in the database
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();
        if ($cartItem) {
            if ($request->operation === 'increase') {
                $cartItem->quantity++;
            } elseif ($request->operation === 'decrease' && $cartItem->quantity > 1) {
                $cartItem->quantity--;
            } elseif ($request->operation === 'decrease' && $cartItem->quantity <= 1) {
                $cartItem->delete();
            }
            $cartItem->save();
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);

            // Remove the cart item from the database
            Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }
}