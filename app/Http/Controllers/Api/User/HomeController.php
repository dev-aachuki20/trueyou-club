<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        try {
            $today = Carbon::today();
            $todayQuote = Quote::whereDate('created_at', $today)->first();

            if (!$todayQuote) {
                $responseData = [
                    'status'     => true,
                    'data'       => null,
                ];
                return response()->json($responseData, 200);
            } else {

                $submissionPercentage = round($todayQuote->users()->count() / getTotalUsers() * 100);

                $responseData = [
                    'status'        => true,
                    'data'          => [
                        'id' => $todayQuote->id,
                        'message' => $todayQuote->message,
                        'submission_percentage' => $submissionPercentage,
                        'today_quote_completed' => auth()->user()->quotes()->where('quote_id',$todayQuote->id)->exists(),
                        'user_active' => auth()->user()->is_active ? true : false,

                    ],
                    
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
        $request->validate([
            'quote_id'    => 'required|numeric',
        ], [
            'quote_id.required'   => 'This field is required',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
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
                    if($user->is_active){
                        $user->quotes()->attach($todayQuote, ['created_at' => now(), 'status' => 'completed']);
    
                        $quoteTasksCount = $user->quotes->count();
                        $countForStar = config('constants.user_star_no_with_task_count');

                        if(!$user->vip_at){
                            if($quoteTasksCount == $countForStar['1_star']){
                                $user->update(['star_no' => 1]);
                            } else if($quoteTasksCount > $countForStar['1_star'] && $quoteTasksCount == $countForStar['2_star']){
                                $user->update(['star_no' => 2]);
                            } else if($quoteTasksCount > $countForStar['2_star'] && $quoteTasksCount == $countForStar['3_star']){
                                $user->update(['star_no' => 3]);
                            } else if($quoteTasksCount > $countForStar['3_star'] && $quoteTasksCount == $countForStar['4_star']){
                                $user->update(['star_no' => 4]);
                            } else if($quoteTasksCount > $countForStar['4_star'] && $quoteTasksCount == $countForStar['5_star']){
                                $user->update(['star_no' => 5, 'vip_at' => now()->format('Y-m-d H:i:s')]);
                                cacheVipUsers('set');
                            }
                        }
                    }
                    DB::commit();
                    $responseData = [
                        'status'        => true,
                        'message'       => "Completed Today Task Successfully!",
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


    public function userNotifications(Request $request){
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->select('id', 'data', 'created_at', 'read_at')->latest()->paginate(10);

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
                    'status'  => true,
                    'data' => null,
                ];
                return response()->json($responseData, 200);
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

    public function getReward(Request $request){
        try {
            $currentUser = Auth::user();
            
            $data = [ 'star' => $currentUser->star_no];
            
            $vipUsers = cacheVipUsers();
            $data['vip_users'] = $vipUsers;
             
            $responseData = [
                'status'  => true,
                'data'    => $data,
            ];
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // dd($e->getMessage().'->'.$e->getLine());

            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
