<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalPaymentController extends Controller
{
    private $_api_context;

    public function __construct()
    {

        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function payWithPaypal(Request $request)
    {
        $amount = $request->get('amount');
        if($amount == null || $amount == '')
        {
            Session::flash('error', 'Amount must be include!');
            return redirect('/');
        }
        else
        {
            return view('paywithpaypal', compact('amount'));
        }
        
    }

    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName('Product 1')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Enter Your transaction description');

        $redirect_urls = new RedirectUrls();
        Session::put('cus_name', $request->cus_name);
        Session::put('invoice', $request->invoice);
        Session::put('amount', $request->amount);
        $redirect_urls->setReturnUrl(URL::route('status'))
            ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                Session::flash('error','Connection timeout');
                return redirect('/');
            } else {
                Session::flash('error','Some error occur, sorry for inconvenient');
                return redirect('/');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }

        Session::flash('error','Unknown error occurred');
    	return redirect('/');
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::flash('error','Payment failed');
            return redirect('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $cus_name = Session::get('cus_name');
            $invoice = Session::get('invoice');
            $amount = Session::get('amount');
            $donate = Donation::create([
                'cus_name' => $cus_name,
                'invoice_id' => $invoice,
                'amount' => $amount,
                'payment_type' => 'Paypal',
            ]);
            if($donate)
            {
                Session::forget(['cus_name', 'invoice', 'amount']);
                Session::flash('success','Payment success !!');
                return redirect('/');
            }
            else
            {
                Session::flash('error','Payment done but database credential not match ! Its a server error !!');
                return redirect('/');
            }
            
        }

        Session::flash('error','Payment failed !!');
		return redirect('/');
    }
}
