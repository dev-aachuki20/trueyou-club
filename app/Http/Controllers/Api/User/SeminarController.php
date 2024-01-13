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
            $getAllSeminar = Seminar::paginate(10);

            if ($getAllSeminar->count() > 0) {
                $responseData = [
                    'status'  => true,
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
                'status'  => false,
                'error'   => trans('messages.error_message'),
            ];
            return response()->json($responseData, 402);
        }
    }
}
