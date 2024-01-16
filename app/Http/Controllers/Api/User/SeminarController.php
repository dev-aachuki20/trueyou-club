<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB; 

class SeminarController extends Controller
{
    public function index()
    {

        try {
            $getAllRecords = Seminar::orderByRaw('
                ABS(TIME_TO_SEC(TIMEDIFF(CONCAT(start_date, " ", start_time), NOW()))) ASC
            ')->paginate(10);
            
            if ($getAllRecords->count() > 0) {

                foreach($getAllRecords as $record){
                    $record->image_url = $record->image_url ? $record->image_url : asset(config('constants.default.no_image'));
                    $record->datetime = convertDateTimeFormat($record->start_date.' '.$record->start_time,'fulldatetime') .'-'. Carbon::parse($record->end_time)->format('h:i A');
                }

                $responseData = [
                    'status'  => true,
                    'data'    => $getAllRecords,
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
}
