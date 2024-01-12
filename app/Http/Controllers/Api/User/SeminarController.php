<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SeminarController extends Controller
{
    public function getAllSeminar()
    {

        try {
            $getAllSeminar = Seminar::all();

            // where('start_date', '>', Carbon::now())
            // ->orderBy('start_date', 'asc')
            // ->get()

            if ($getAllSeminar->count() > 0) {
                $responseData = [
                    'status'  => true,
                    'message' => 'All Seminar',
                    'data'    => $getAllSeminar,
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
            $responseData = [
                'status'  => 500,
                'message' => 'Internal Server Error',
                'error'   => $e->getMessage(),
            ];
            return response()->json($responseData, 500);
        }
    }
}
