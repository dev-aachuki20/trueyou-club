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
}
