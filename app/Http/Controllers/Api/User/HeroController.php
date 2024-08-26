<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Heroe;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        try {

            $currentDate = now()->toDateString();
            $getAllRecords = Heroe::select('id', 'name', 'slug', 'description', 'created_at', 'created_by')                
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            if ($getAllRecords->count() > 0)
            {             
                foreach ($getAllRecords as $key=>$record)
                {                   
                    $record->created_at = convertDateTimeFormat($record->created_at, 'fulldate');             
                    $record->image_url = $record->featured_image_url ? $record->featured_image_url : asset(config('constants.default.no_image'));                   
                    $record->created_by  = $record->user->name ?? null;                    
                    $record->makeHidden(['user', 'featuredImage']);                    
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
            ];
            return response()->json($responseData, 500);
        }
    }

}
