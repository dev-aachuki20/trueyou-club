<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Customer;
use App\Models\Seminar;
use App\Models\User;
use App\Models\UserToken;
use App\Models\Transaction;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Subscription as StripeSubscription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(Request $request)
    {
        $this->default_currency = config('constants.default_currency');
        $this->stripeSecret = Stripe::setApiKey(config('app.stripe_secret_key'));
    }

    public function config()
    {
        try {
            $responseData = [
                'status'            => true,
                'key'               => config('app.stripe_publishable_key'),
            ];

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 400);
        }
    }

    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'seminar' => 'required',
        ]);

        try {
            $seminar = Seminar::where('id',$request->seminar)->first();

            if(!$seminar){
                return response()->json(['errors' => 'Invalid Seminar!'], 422);
            }

            // Set your Stripe secret key
            $stripeSecretKey = getSetting('stripe_secret_key') ? getSetting('stripe_secret_key') : config('app.stripe_secret_key');
            $stripePublishableKey = getSetting('stripe_publishable_key') ? getSetting('stripe_publishable_key') : config('app.stripe_publishable_key');

            Stripe::setApiKey($stripeSecretKey);

            $authUser = auth()->user();

            //Start To Set Token
            $token = Str::random(32);
            $userToken = UserToken::where('user_id', $authUser->id)->first();
            if ($userToken) {
                $userToken->update([
                    'token' => $token,
                    'type'  =>'checkout_token',
                ]);
            } else {
                $userToken = UserToken::create([
                    'user_id' => $authUser->id,
                    'token'   => $token,
                    'type'    => 'checkout_token',
                ]);
            }
            //End To Set Token

            // Retrieve customer details by email
            // $customers = Customer::all(['email' => $authUser->email]);

            // dd($customers->data[0]);

            // Create or retrieve Stripe customer
            if (is_null($authUser->stripe_customer_id)) {
                $customer = Customer::create([
                    'name'  => $authUser->name,
                    'email' => $authUser->email,
                ]);
                $authUser->stripe_customer_id = $customer->id;
                $authUser->save();
            } else {
                $customer = Customer::retrieve($authUser->stripe_customer_id);
            }

            $metadata = [
                'seminar' => json_encode([
                    'id' => $seminar->id,
                    'title' => ucwords($seminar->title),
                    'total_ticket'=> $seminar->total_ticket,
                    'ticket_price'=> $seminar->ticket_price,
                    'venue' => $seminar->venue,
                    'start_date' => $seminar->start_date,
                    'start_time' => $seminar->start_time,
                    'end_time'   => $seminar->end_time,
                ]),
            ];

    
            $sessionData = [
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => config('constants.default_currency'),
                            'product_data' => [
                                'name' => ucwords($seminar->title),
                            ],
                            'unit_amount' => (float)$seminar->ticket_price * 100, // Amount in cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => env('FRONTEND_URL') . 'completion/'.$token, 
                'cancel_url' => env('FRONTEND_URL') . 'cancel',    
                'metadata' => $metadata,
            ];
           
            if ($customer) {
                $sessionData['customer'] = $customer->id;
            }

            // Create a Checkout Sessions
            $session = StripeSession::create($sessionData);

            return response()->json(['session' => $session]);
        } catch (\Exception $e) {
            // dd($e->getMessage().'->'.$e->getLine());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkoutSuccess(Request $request)
    {

        $requestToken = $request->token;
        $authUser = auth()->user();

        $userToken = UserToken::where('user_id', $authUser->id)->where('token', $requestToken)->first();

        if ($userToken) {
            // The request is from the same session.
            if ($authUser->is_buyer) {
                $buyerPlan = BuyerPlan::where('plan_stripe_id', $userToken->plan_stripe_id)->first();

                if($buyerPlan){
                $updateBuyerPlan = Buyer::where('buyer_user_id', $authUser->id)->update(['plan_id' => $buyerPlan->id, 'is_plan_auto_renew' =>1]);
                    $response = [
                        'status' => true,
                        'message' => 'Your payment is successfully completed.'
                    ];
                }else{
                    $response = [
                        'status' => true,
                        'message' => 'Invalid buyer plan.'
                    ];
                }
            } else {
                                        
                $plan = Plan::where('plan_stripe_id', $userToken->plan_stripe_id)->first();
                $addonPlan = Addon::where('price_stripe_id', $userToken->plan_stripe_id)->first();
                if ($plan) {
                    $authUser->credit_limit = $plan->credits ?? 0;
                } else if ($addonPlan) {
                    $authUser->credit_limit = (int)$authUser->credit_limit + (int)$addonPlan->credit;
                }
                $authUser->level_type = 2;
                $authUser->save();

                $response = ['status' => true, 'credit_limit' => $authUser->credit_limit];
            }
          
            $userToken->token = null;
            $userToken->plan_stripe_id = null;
            $userToken->save();
               
            return response()->json($response, 200);
        } else {
            // The request is not from the same session.
            return response()->json(['status' => false], 404);
        }
    }


  
  
}
