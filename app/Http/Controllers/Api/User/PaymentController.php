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
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function createCheckoutSession(Request $request)
    {
       
        $rules['name'] = 'required|string';
        $rules['email'] = 'required|string|email';
        $rules['seminar'] = 'required|exists:seminars,id';

        $request->validate($rules);

        try {
            $seminar = Seminar::where('id',$request->seminar)->first();

            // Set your Stripe secret key
            $stripeSecretKey = getSetting('stripe_secret_key') ? getSetting('stripe_secret_key') : config('app.stripe_secret_key');
            $stripePublishableKey = getSetting('stripe_publishable_key') ? getSetting('stripe_publishable_key') : config('app.stripe_publishable_key');

            Stripe::setApiKey($stripeSecretKey);

            $authUser = User::where('email',$request->email)->first();

            //Start To Set Token
            $token = Str::random(32);
            $userEmail =  !$authUser ? $request->email :  $authUser->email;

            $userToken = UserToken::where('email', $userEmail)->first();
            if ($userToken) {
                $userToken->update([
                    'token' => $token,
                    'type'  =>'checkout_token',
                ]);
            } else {
                $userToken = UserToken::create([
                    'email'   => $userEmail,
                    'token'   => $token,
                    'type'    => 'checkout_token',
                ]);
            }
            //End To Set Token

            // Retrieve customer details by email
            $customers = Customer::all(['email' => $userEmail]);
            $customerStripeId = null;
            if( isset($customers->data[0]) ){
                $customer = $customers->data[0];
                $customerStripeId = $customer->id;
            }else{
                $customer = Customer::create([
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);

                $customerStripeId = $customer->id;
            }

            // dd($customers->data[0]);

            //Update stripe id if user authenticate
            if( $authUser ){
                $authUser->stripe_customer_id = $customerStripeId;
                $authUser->save();
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
           
            if ($customerStripeId) {
                $sessionData['customer'] = $customerStripeId;
            }

            // Create a Checkout Sessions
            $session = StripeSession::create($sessionData);

            return response()->json(['status'=>true,'session' => $session]);
        } catch (\Exception $e) {
            // dd($e->getMessage().'->'.$e->getLine());
            return response()->json(['status'=>false,'error' => $e->getMessage()], 500);
        }
    }

    public function checkoutSuccess(Request $request)
    {

        $authUser = auth()->user();

        if( !$authUser ){
            $rules['email'] = 'required|string|email';
        }

        $rules['token'] = 'required';

        $request->validate($rules);

        $requestEmail = null;

        if($authUser){
            $requestEmail = $authUser->email;
        }else{
            $requestEmail = $request->email;
        }
       
        $userToken = UserToken::where('email', $requestEmail)->where('token', $request->token)->first();

        if ($userToken) {
            
            $userToken->token = null;
            $userToken->save();
               
            return response()->json($response, 200);
        } else {
            // The request is not from the same session.
            return response()->json(['status' => false], 404);
        }
    }


  
  
}
