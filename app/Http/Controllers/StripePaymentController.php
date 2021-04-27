<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)

    {
        $amount = $request->get('amount');
        if($amount == null || $amount == '')
        {
            Session::flash('error', 'Amount must be include!');
            return redirect('/');
        }
        else
        {
            return view('stripe', compact('amount'));
        }

    }



    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)

    {
        $description = 'Customer: '.$request->cus_name.'|Invoice: '.$request->invoice;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Stripe\Charge::create([

            "amount" => $request->amount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => $description,

        ]);

        if($charge['status'] == 'succeeded')
        {
            Donation::create([
                'cus_name' => $request->cus_name,
                'invoice_id' => $request->invoice,
                'amount' => $request->amount,
                'payment_type' => 'Stripe',
            ]);
            Session::flash('success', 'Payment successful!');
            return redirect('/');
        }
        else
        {
            Session::flash('error', 'Payment unsuccessful!');
            return redirect('/');
        }

    }
}
