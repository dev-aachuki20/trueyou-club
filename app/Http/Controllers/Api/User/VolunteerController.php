<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\VolunteerAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    public function volunteerAvailablity(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year'  => 'required',
        ]);

        try {
            $month = $request->month;
            $year  = $request->year;

            $records = VolunteerAvailability::select('id','date','start_time','end_time')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get()
            ->groupBy(function($record) {
                return Carbon::parse($record->date)->format('Y-m-d');
            });

            foreach($records as $dateRecords){
                foreach($dateRecords as $record){
                    $record->formatted_date = $record->date->format('Y-m-d');
                }
            }

            $responseData = [
                'status'  => true,
                'data'    => $records,
            ];                 
            return response()->json($responseData, 200);
         
        } catch (\Exception $e) {
            // dd($e->getMessage().'->'.$e->getLine());

            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
                'error_details' => $e->getMessage().'->'.$e->getLine()
            ];
            return response()->json($responseData, 500);
        }
    }

    public function storeVolunteerAvailablity(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date_format:Y-m-d'], 
            'time_slots' => ['required', 'array', 'min:1'], 
            'time_slots.*.start_time' => ['required', 'regex:/^(0?[1-9]|1[0-2]):?[0-5]?[0-9]?(AM|PM)$/i'],
            'time_slots.*.end_time'   => ['required', 'regex:/^(0?[1-9]|1[0-2]):?[0-5]?[0-9]?(AM|PM)$/i', function ($attribute, $value, $fail) use ($request) {
                // Extract the index from the attribute (e.g., 'time_slots.0.end_time' -> 0)
                $index = explode('.', $attribute)[1];
                $start_time = $request->input("time_slots.$index.start_time");
        
                // Convert times to 24-hour format using Carbon
                try {
                    $startTime24 = Carbon::parse($start_time)->format('H:i');
                    $endTime24 = Carbon::parse($value)->format('H:i');
        
                    // Check if end_time is after start_time
                    if ($endTime24 <= $startTime24) {
                        $fail('The end time must be after the start time.');
                    }
                } catch (\Exception $e) {
                    $fail('Invalid time format.');
                }
            }],
        ]);

        try{
            DB::beginTransaction();
            
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $time_slots = $request->time_slots;
            foreach($time_slots as $slot){
                $startTime24 = Carbon::parse($slot['start_time'])->format('H:i');
                $endTime24 = Carbon::parse($slot['end_time'])->format('H:i');

                $availablityData = [
                    'date'       => $date,
                    'start_time' => $startTime24,
                    'end_time'   => $endTime24,
                ];

                VolunteerAvailability::create($availablityData);

            }

            DB::commit();
            
            $responseData = [
                'status'  => true,
                'message' => 'Availablity added successfully!'
            ];
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            DB::rollBack();
    
            $responseData = [
                'status'  => false,
                'error'   => trans('messages.error_message'),
                'error_details' => $e->getMessage().'->'.$e->getLine()
            ];
            return response()->json($responseData, 500);
        }
    }
}
