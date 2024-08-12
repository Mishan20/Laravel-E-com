<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Exception;
use Twilio\Rest\Client;

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
        $total = $cart->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return view('stripe', compact('total'));
    }

    /**
     * Handle the Stripe payment and send SMS notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(config('services.stripe.sk'));

        try {
            // Process the payment
            $charge = Stripe\Charge::create([
                "amount" => $request->total * 100, // Stripe accepts amounts in cents
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment from Mishan-Ecom.live"
            ]);

            // Clear the user's cart after successful payment
            Cart::where('user_id', Auth::id())->delete();

            // Send SMS notification
            $account_sid = config('services.twilio.sid');
            $auth_token = config('services.twilio.token');
            $twilio_number = config('services.twilio.from');
            $receiverNumber = "+94766277163"; // Replace with dynamic or user-specific number

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => "Your payment of $" . $request->total . " was successful."
            ]);

            return back()->with('success', 'Payment successful! SMS sent to ' . $receiverNumber);
        } catch (Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
