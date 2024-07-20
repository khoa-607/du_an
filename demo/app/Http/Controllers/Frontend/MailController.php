<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class MailController extends Controller
{
    public function index()
    {
        return view('frontend.mail.mail');
    }

    public function send(Request $request)
    {
        $cart = json_decode($request->query('cart'), true);
        $cartHTML = $request->query('cartHTML');
        $user = Auth::user();
    
        if(!$user || !$cart) {
            return response()->json(['success' => false, 'message' => 'User not authenticated or cart is empty']);
        }
    
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) + 2; // Adding Eco Tax
    
        // Prepare mail data
        $mailData = [
            'subject' => 'Your Order Details',
            'cart' => $cart,
            'totalPrice' => $totalPrice,
            'cartHTML' => $cartHTML
        ];
    
        try {
            // Send email
            Mail::to($user->email)->send(new MailNotify($mailData));
    
            // Optionally, save to history or perform other actions
    
            return response()->json(['success' => true, 'message' => 'Mail sent successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send mail: ' . $e->getMessage()]);
        }
    }
}
