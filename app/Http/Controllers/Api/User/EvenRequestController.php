<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();        

        try
        {
            $getAllRecords = EventRequest::select('id', 'event_id', 'volunteer_id', 'custom_message','status', 'created_at', 'created_by')
                ->where('volunteer_id',$user->id)                
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            
            if ($getAllRecords->count() > 0)
            {                
                $responseData = [
                    'status'  => true,
                    'data' => $getAllRecords->map(function ($record) {
                        return [
                            'id' => $record->id,
                            'status' => $record->status,
                            'custom_message' => $record->custom_message ?? '',
                            'created_at' => $record->created_at,
                            'event' => [
                                'id' => $record->event->id,
                                'title' => $record->event->title ?? '',
                                'slug' => $record->event->slug ?? '',
                                'description' => $record->event->description ?? '',
                                'created_at' => $record->created_at,
                                'created_by'  => $record->user->name ?? null,
                                'image_url' => $record->featured_image_url ? $record->featured_image_url : asset(config('constants.default.no_image')),  
                            ]                                                      
                        ];
                    }),
                ];
                return response()->json($responseData, 200);
            } else {
                $responseData = [
                    'status'  => false,
                    'data'    => $getAllRecords,
                    'message' => 'No Record Found',
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

    public function updateStatus(Request $request)
    {     
        try{            
            $volunteer_id = Auth::user()->id;
            $request->validate([
                'id' => 'required|numeric|exists:event_requests,id',
                'status' => 'required|in:'.implode(',',array_keys(config('constants.event_request_status')))
            ]);

            EventRequest::where('id',$request->id)->where('volunteer_id',$volunteer_id)->update(['status'=> $request->status]);

            $responseData = [
                'status'  => true,
                'message' => 'Successfully Changed !'
                
            ];
            return response()->json($responseData, 200);

        }catch(\Exception $e){
            dd($e->getMessage().'->'.$e->getLine());
            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
