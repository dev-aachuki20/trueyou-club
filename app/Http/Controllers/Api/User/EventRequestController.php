<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();        

        try
        {
            $getAllRecords = EventRequest::with(['event' => function($query) {
                $query->select(['id', 'title', 'slug', 'description', 'event_date', 'start_time'])
                      ->where(function($query) {
                          $query->where('event_date', '>', now()->toDateString());
                                // ->orWhere(function($query) {
                                //     $query->where('event_date', '=', now()->toDateString())
                                //           ->where('start_time', '>', now()->toTimeString());
                                // });
                      });
            }])->select('id', 'event_id', 'volunteer_id', 'custom_message', 'status', 'created_at', 'created_by')
                ->where('status',0)
                ->where('volunteer_id', $user->id)
                ->whereHas('event', function($query) {
                    $query->where(function($query) {
                        $query->where('event_date', '>', now()->toDateString());
                            //   ->orWhere(function($query) {
                            //       $query->where('event_date', '=', now()->toDateString())
                            //             ->where('start_time', '>', now()->toTimeString());
                            //   });
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            
            if ($getAllRecords->count() > 0){  
                foreach ($getAllRecords as $key=>$record)
                {        
                    $record->formatted_date  = convertDateTimeFormat($record->created_at, 'fulldate');                            
                    $record->time            = $record->created_at->format('H:i A');                               
                    $record->created_by      = $record->user->name ?? null;                    
                    $record->makeHidden(['user']);

                    if ($record->event) {
                        $formattedEventDate = convertDateTimeFormat($record->event->event_date, 'fulldate');
                        $record->event->formatted_event_date = $formattedEventDate;
                        $record->event->start_time  = convertDateTimeFormat($record->event->start_time, 'fulltime');  
                        $record->event->image_url   = $record->event->featured_image_url ? $record->event->featured_image_url : asset(config('constants.default.no_image')); 
                        $record->event->created_by  = $record->user->name ?? null;    

                        $record->event->makeHidden(['user', 'featuredImage']);       
                    }
                }                    
                 
                $responseData = [
                    'status'  => true,
                    'data' => $getAllRecords,
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
                'error_details' => $e->getMessage().'->'.$e->getLine(),
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

            $message = 'Reponse Submitted!';
            if($request->status == 1){
                $message = trans('message.event.accepted');
            }else if($request->status == 2){
                $message = trans('message.event.declined');
            }
            
            $responseData = [
                'status'  => true,
                'message' => $message 
            ];
            return response()->json($responseData, 200);

        }catch(\Exception $e){
            // dd($e->getMessage().'->'.$e->getLine());
            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
                'error_details' => $e->getMessage().'->'.$e->getLine()
            ];
            return response()->json($responseData, 500);
        }
    }

    public function eventHistory()
    {
        $user = Auth::user();        

        try
        {
            $getAllRecords = EventRequest::/*with(['event' => function($query) {
                $query->select(['id', 'title', 'slug', 'description', 'event_date', 'start_time'])
                        
                      ->where(function($query) {
                          $query->where('event_date', '<', now()->toDateString())
                                ->orWhere(function($query) {
                                    $query->where('event_date', '=', now()->toDateString())
                                          ->where('start_time', '<', now()->toTimeString());
                                });
                      });
            }])
            ->*/select('id', 'event_id', 'volunteer_id', 'custom_message', 'status', 'created_at', 'created_by')                
                ->where('volunteer_id', $user->id)
                /*
                ->whereHas('event', function($query) {
                    $query->where(function($query) {
                        $query->where('event_date', '<', now()->toDateString())
                              ->orWhere(function($query) {
                                  $query->where('event_date', '=', now()->toDateString())
                                        ->where('start_time', '<', now()->toTimeString());
                              });
                    });
                })
                */
                ->orderBy('updated_at', 'desc')
                ->paginate(12);
            
            if ($getAllRecords->count() > 0){  
                foreach ($getAllRecords as $key=>$record)
                {        
                    $record->formatted_date  = convertDateTimeFormat($record->created_at, 'fulldate');                            
                    $record->time            = $record->created_at->format('H:i A');                               
                    $record->created_by      = $record->user->name ?? null;                    
                    $record->makeHidden(['user']);

                    if ($record->event) {
                        $formattedEventDate = convertDateTimeFormat($record->event->event_date, 'fulldate');
                        $record->event->formatted_event_date = $formattedEventDate;
                        $record->event->start_time  = convertDateTimeFormat($record->event->start_time, 'fulltime');  
                        $record->event->image_url   = $record->event->featured_image_url ? $record->event->featured_image_url : asset(config('constants.default.no_image')); 
                        $record->event->created_by  = $record->user->name ?? null;    

                        $record->event->makeHidden(['user', 'featuredImage']);       
                    }
                }                    
                 
                $responseData = [
                    'status'  => true,
                    'data' => $getAllRecords,
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
                'error_details' => $e->getMessage().'->'.$e->getLine(),
            ];
            return response()->json($responseData, 500);
        }
    }
}
