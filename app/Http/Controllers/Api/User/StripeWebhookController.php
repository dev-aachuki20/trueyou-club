<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Customer;
use App\Models\User;
use App\Models\UserToken;
use App\Models\Booking;
use App\Models\Seminar;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\PurchasedSeminarTicketMail;

class StripeWebhookController extends Controller
{
    
    public function handleStripeWebhook(Request $request)
    {
        Log::info('Start stripe webhook');

        $stripeSecretKey = getSetting('stripe_secret_key') ? getSetting('stripe_secret_key') : config('app.stripe_secret_key');
        // $stripePublishableKey = getSetting('stripe_publishable_key') ? getSetting('stripe_publishable_key') : config('app.stripe_publishable_key');

        Stripe::setApiKey($stripeSecretKey);
        
        $payload = $request->getContent();
        $stripeSignatureHeader = $request->header('Stripe-Signature');

        $endpointSecret = getSetting('stripe_webhook_secret_key') ? getSetting('stripe_webhook_secret_key') : env('STRIPE_WEBHOOK_SECRET_KEY'); // Replace with the actual signing secret

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $stripeSignatureHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            Log::info('Invalid payload!');
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::info('Invalid signature!');
            $data = [
                'error_message' => $e->getMessage() . '->' . $e->getLine()
            ];
            return response()->json(['error' => 'Invalid signature', 'data' => $data], 400);
        }

        try {
            // Handle the event based on its type
            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($event->data->object);
                break;

                case 'checkout.session.async_payment_failed':
                    $this->handlePaymentFailed($event->data->object);
                break;

                default:
                    Log::info('Invalid Event fired!');
            }
        } catch (\Exception $e) {

            // dd($e->getMessage().'->'.$e->getLine());
            return response()->json(['error' => $e->getMessage() . '->' . $e->getLine()], 500);
            // return response()->json(['error' => 'Something went wrong!'], 400);
        }

        Log::info('End stripe webhook');

        return response()->json(['success' => true]);
    }


    private function handleCheckoutSessionCompleted($eventDataObject)
    {
        Log::info('Start stripe webhook of checkout session completed');
        
        $customer_stripe_id = $eventDataObject->customer;

        if (isset($eventDataObject->metadata->seminar)) {
            $customer = User::where('stripe_customer_id', $customer_stripe_id)->first();
            $customerDetails = json_encode($eventDataObject->customer_details);

            $customerName = $eventDataObject->customer_details->name;
            $customerEmail = $eventDataObject->customer_details->email;

            $transaction = Transaction::where('payment_intent_id', $eventDataObject->payment_intent)->where('status','success')->exists();
            if (!$transaction) {
               
                // Save data to transactions table
                Transaction::create([
                    'user_id' => $customer ? $customer->id : null,
                    'user_json' => $customerDetails,
                    'payment_intent_id' => $eventDataObject->payment_intent,
                    'amount' => (float)$eventDataObject->amount_total / 100,
                    'currency' => $eventDataObject->currency,
                    'payment_method' => $eventDataObject->payment_method_types[0],
                    'payment_type'   => 'credit',
                    'status' => 'success',
                    'payment_json' => json_encode($eventDataObject),
                ]);

                //Make entry in booking table
                $seminarId = json_decode($eventDataObject->metadata->seminar)->id;

                $seminarBooking = Seminar::find($seminarId);
                $booking = $seminarBooking->bookings()->create([
                    'user_id' => $customer ? $customer->id : null,
                    'user_details' =>  $customerDetails,
                    'bookingable_details'=> $eventDataObject->metadata->seminar,
                    'booking_number' => generateBookingNumber(), 
                    'type'=>'seminar',
                ]);


                // $subject = 'Seminar Ticket Purchased';
                // Mail::to($customerEmail)->queue(new PurchasedSeminarTicketMail($subject, $customerName, $customerEmail,$seminarBooking));
    
                if($customer){
                    $notification_message = config('constants.seminar_booked_notification_message');
                    Notification::send($customer, new UserNotification($customer, $notification_message));    
                }
              

            }
        }
        

    }


    private function handlePaymentFailed($eventDataObject)
    {
        Log::info('Start stripe webhook of invoice payment failed');
       
        $customer_stripe_id = $eventDataObject->customer;

        $metaData = $eventDataObject->subscription_details->metadata ?? null;

        if($metaData && $metaData->user_type){

            if($metaData->user_type == 'seller'){
                $customer = User::where('stripe_customer_id', $customer_stripe_id)->first();
                $customerId = $customer->id ?? null;

                $isAddon = false;
                $planId = Plan::where('plan_stripe_id', $eventDataObject->lines->data[0]->plan->id)->value('id');
                if (!$planId) {
                    $planId = Addon::where('product_stripe_id', $eventDataObject->lines->data[0]->plan->id)->value('id');
                    $isAddon = true;
                }

                $transaction = Transaction::where('user_id', $customerId)->where('payment_intent_id', $eventDataObject->payment_intent)->where('status','failed')->exists();
                if (!$transaction) {
                    if (!is_null($customerId) && !is_null($planId)) {
                        // Save data to transactions table
                        Transaction::create([
                            'user_id' => $customerId,
                            'plan_id' => $planId,
                            'is_addon' => $isAddon,
                            'payment_intent_id' => $eventDataObject->payment_intent,
                            'amount' => (float)$eventDataObject->lines->data[0]->amount / 100,
                            'currency' => $eventDataObject->lines->data[0]->currency,
                            'payment_method' => null,
                            'payment_type'   => 'credit',
                            'status' => 'failed',
                            'payment_json' => json_encode($eventDataObject),
                        ]);

                        $customer->level_type = 1;
                        $customer->save();
                    }
                }
            }
            
            else if($metaData->product_type == 'boost-plan' && $metaData->user_type == 'buyer'){
              /*  $authUser = User::where('stripe_customer_id', $customer_stripe_id)->first();

                $transaction = BuyerTransaction::where('user_id', $authUser->id)->where('payment_intent_id', $eventDataObject->payment_intent)->where('status','failed')->exists();

                if (!$transaction) {

                    $userJson = [
                        'stripe_customer_id' => $authUser->stripe_customer_id,
                        'name'  => $authUser->name,
                        'email' => $authUser->email,
                        'phone' => $authUser->phone,
                        'register_type' => $authUser->register_type,
                        'email_verified_at' => $authUser->email_verified_at,
                        'phone_verified_at' => $authUser->phone_verified_at,
                    ];

                    $planJson = BuyerPlan::find($authUser->buyerDetail->plan_id);

                    BuyerTransaction::create([
                        'user_id' => $authUser->id,
                        'user_json' => json_encode($userJson),
                        'plan_id'   => $planJson ? $planJson->id : null,
                        'plan_json' =>  $planJson ? $planJson->toJson() : null,
                        'payment_intent_id' => $eventDataObject->payment_intent,
                        'amount' => (float)$eventDataObject->total / 100,
                        'currency' => $eventDataObject->currency,
                        'payment_method' => $eventDataObject->payment_method_types[0] ?? null,
                        'payment_type'   => 'credit',
                        'status' => 'failed',
                        'payment_json' => json_encode($eventDataObject),
                    ]);

                }
                */
            }
        }

    }

}
