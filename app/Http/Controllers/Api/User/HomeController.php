<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use App\Models\Role;
use Carbon\Carbon;

class HomeController extends Controller
{

    // today quote with percentage
    public function index()
    {
        try {
            $today = Carbon::today();
            $todayQuote = Quote::whereDate('created_at', $today)->first();

            if (!$todayQuote) {
                $responseData = [
                    'status'        => false,
                    'message'       => "No quote exist",
                ];
                return response()->json($responseData, 404);
            } else {

                $submissionPercentage = $todayQuote->users()->count() / $this->getTotalUsers() * 100;

                $quoteMessage = $todayQuote->message;
                $responseData = [
                    'status'        => true,
                    'message'       => $quoteMessage,
                    'submission_percentage' => $submissionPercentage . '%',
                ];
                return response()->json($responseData, 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage() . '->' . $e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'quote_id'    => 'required|numeric',
        ], [
            'quote_id.required'   => 'This field is required',
        ]);

        DB::beginTransaction();
        try {
            $user = User::find($user_id);
            $todayQuote = Quote::find($request->quote_id);
            if (!$todayQuote) {
                $responseData = [
                    'status'        => false,
                    'message'       => "No quote exist in record",
                ];
                return response()->json($responseData, 404);
            } else {
                $todayQuoteData = $todayQuote->created_at->format('Y-m-d');
                $today = Carbon::today()->format('Y-m-d');

                if ($todayQuoteData == $today) {
                    $user->quotes()->attach($todayQuote, ['created_at' => now()]);
                    DB::commit();
                    $responseData = [
                        'status'        => true,
                        'message'       => "Task added successfully",
                    ];
                    return response()->json($responseData, 200);
                } else {
                    $responseData = [
                        'status'        => false,
                        'message'       => "Invalid quote for today",
                    ];
                    return response()->json($responseData, 404);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage() . '->' . $e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }

    protected function getTotalUsers()
    {
        // get the total count of users
        $role = Role::where('title', 'User')->first();
        return $role ? $role->users()->count() : 0;
    }

    public function leadBoardUser()
    {
        try {
            $today = Carbon::today();
            $todaysQuote = Quote::whereDate('created_at', $today)->first();

            if ($todaysQuote) {
                $leadUsersList = $todaysQuote->users->map(function ($user) {
                    return [
                        'username' => $user->name,
                        'image_url' => $user->profile_image_url ? asset($user->profile_image_url) : asset(config('constants.default.no_image')),
                    ];
                });

                $responseData = [
                    'status'        => true,
                    'message'       => 'Lead Board Users list',
                    'leadUsersList' => $leadUsersList,
                ];

                return response()->json($responseData, 200);
            } else {
                $responseData = [
                    'status'        => false,
                    'message'       => "No user exist",
                ];

                return response()->json($responseData, 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage() . '->' . $e->getLine());

            // Return Error Response
            $responseData = [
                'status' => false,
                'error'  => trans('messages.error_message'),
            ];

            return response()->json($responseData, 500);
        }
    }

    public function notifications(Request $request){
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->select('id', 'data', 'created_at', 'read_at')->latest()->paginate(10);;

            if ($notifications->count() > 0) {
                foreach ($notifications as $key=>$record) {
                    $now = Carbon::now();
                    $notificationDate = Carbon::parse($record->created_at)->diffForHumans($now);
                    $notificationDate = str_replace('before', 'ago', $notificationDate);

                    $record->notification_date = $notificationDate;

                    $notificationData = $record->data;
                    $record->notification_message = $notificationData['message'];
                }
                $responseData = [
                    'status'  => true,
                    'data'    => $notifications,
                ];
                return response()->json($responseData, 200);
            } else {
                $responseData = [
                    'status'  => false,
                    'message' => 'No Record Found',
                ];
                return response()->json($responseData, 404);
            }
        } catch (\Exception $e) {
            // dd($e->getMessage().'->'.$e->getLine());

            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }

    public function deleteNotification(Request $request, $id){
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $notification = $user->notifications()->where('id', $id)->first();
            if($notification){
                $notification->delete();
                DB::commit();

                $responseData = [
                    'status'        => true,
                    'message'       => "Notification deleted successfully",
                ];
                return response()->json($responseData, 200);
            } else {
                $responseData = [
                    'status'        => false,
                    'message'       => "No data found",
                ];
                return response()->json($responseData, 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage() . '->' . $e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
