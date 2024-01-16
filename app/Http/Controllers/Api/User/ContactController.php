<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class ContactController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email',
            'phone_number'  => 'required|digits:10',
            'message'       => 'required',
        ], [
            'first_name.required'   => 'This field is required',
            'last_name.required'    => 'This field is required',
            'email.required'        => 'This field is required',
            'phone_number.required' => 'This field is required',
            'phone_number.digits'   => 'The phone number must be 10 digits',
        ]);

        DB::beginTransaction();
        try {
            $storeRecords = [
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'name'          => $request->first_name . ' ' . $request->last_name,
                'phone_number'  => $request->phone_number,
                'email'         => $request->email,
                'message'       => $request->message,
            ];

            $contactData = Contact::create($storeRecords);

            DB::commit();

            $responseData = [
                'status'        => true,
                'message'       => "We appreciate you getting in touch with us! Your request has been successfully sent. We'll get in touch shortly.",
            ];
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            //  dd($e->getMessage().'->'.$e->getLine());

            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 400);
        }
    }
}
