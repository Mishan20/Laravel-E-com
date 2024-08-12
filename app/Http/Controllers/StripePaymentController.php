<?php
      
      namespace App\Http\Controllers;

      use Illuminate\Http\Request;
      use Stripe;
      use Illuminate\Support\Facades\Auth;
      use App\Models\Cart;
      
      class StripePaymentController extends Controller
      {
          /**
           * Show the Stripe payment page.
           *
           * @return \Illuminate\View\View
           */
          public function stripe(Request $request)
          {
              // Calculate the total amount from the cart
              $userId = Auth::id();
              $cart = Cart::where('user_id', $userId)->get();
              $total = $cart->sum(function($item) {
                  return $item->quantity * $item->price;
              });
      
              return view('stripe', compact('total'));
          }
      
          /**
           * Handle the Stripe payment.
           *
           * @return \Illuminate\Http\RedirectResponse
           */
          public function stripePost(Request $request)
          {
              Stripe\Stripe::setApiKey(config('services.stripe.sk'));
      
              Stripe\Charge::create([
                  "amount" => $request->total * 100, // Stripe accepts amounts in cents
                  "currency" => "usd",
                  "source" => $request->stripeToken,
                  "description" => "Payment from Mishan-Ecom.live"
              ]);
      
              // Clear the user's cart after successful payment
              Cart::where('user_id', Auth::id())->delete();
      
              return back()->with('success', 'Payment successful! Your cart has been cleared.');
          }
      }