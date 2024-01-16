<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function userDetails()
    {
        // Get the authenticated user
        $user = Auth::user();
       
        $user_details = [
            'first_name' => $user->first_name ?? null,
            'last_name'  => $user->last_name ?? null,
            'name'       => $user->name ?? null,
            'email'      => $user->email ?? null,
            'phone'      => $user->phone ?? null,
            'profile_image' => $user->profile_image_url ?? null,
            'is_active'  => $user->is_active ?? 0,
        ];
        // Return response
        $responseData = [
            'status' => true,
            'data'   => $user_details,
        ];
        return response()->json($responseData, 200);
    }

    public function updateProfile(Request $request){

        $userId = auth()->user()->id;

        $validatedData = [
            'name'  => 'required',
            'phone' => 'required',
        ];

       
        // if(!auth()->user()->email){
        //     $validatedData['email']  = ['required', 'string', 'email', 'max:255', Rule::unique((new User)->getTable(), 'email')->ignore($userId)->whereNull('deleted_at')];
        // }


        $request->validate($validatedData,[
            'confirm_password.same' => 'The confirm password and new password must match.'
        ]);

        DB::beginTransaction();
        try {
            $fullName = explode(' ',$request->name);

            $updateRecords = [
                'first_name'  => $fullName[0],
                'last_name'  => isset($fullName[1]) ? $fullName[1] : null ,
                'name'  => $request->name,
                'phone' => $request->phone,
            ];

            // if($request->email){
            //     $updateRecords['email'] = $request->email;
            // }

            $updatedUserRecord = User::find($userId)->update($updateRecords);

            DB::commit();

            if($updatedUserRecord){
                //Return Success Response
                $responseData = [
                    'status'        => true,
                    'message'       => 'Profile has been updated',
                ];

                return response()->json($responseData, 200);
            }


        }catch (\Exception $e) { 
            DB::rollBack();
            //  dd($e->getMessage().'->'.$e->getLine());
            
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }

    }

    public function changeProfileImage(Request $request){
        $userId = auth()->user()->id;

        $validatedData['profile_image'] = ['required','image','mimes:jpeg,jpg,png','max:'.config('constants.profile_image_size')];
        
        $request->validate($validatedData);

        DB::beginTransaction();
        try {
           
            $fetchUser = User::find($userId);

            DB::commit();
            if($fetchUser){
                // Start to Update Profile Image
                if($request->hasFile('profile_image')){
                   
                    $actionType = 'save';
                    $uploadId = null;
                    if($fetchUser->profileImage){
                        $uploadId = $fetchUser->profileImage->id;
                        $actionType = 'update';
                    }
                    uploadImage($fetchUser, $request->file('profile_image'), 'user/profile-images',"profile", 'original', $actionType, $uploadId);
                }
                // End to Update Profile Image

                //Return Success Response
                $responseData = [
                    'status'        => true,
                    'message'       => 'Profile Image Uploaded Successfully!',
                ];

                return response()->json($responseData, 200);
            }


        }catch (\Exception $e) { 
            DB::rollBack();
            //  dd($e->getMessage().'->'.$e->getLine());
            
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }

    public function updateStatus(Request $request){
        $userId = auth()->user()->id;

        $validatedData['status'] = ['required','in:0,1'];
        
        $request->validate($validatedData);

        DB::beginTransaction();
        try {
           
            $fetchUser = User::where('id',$userId)->update(['is_active'=>$request->status]);

            DB::commit();
            if($fetchUser){
               
                //Return Success Response
                $responseData = [
                    'status'        => true,
                    'message'       => 'Status Updated Successfully!',
                ];

                return response()->json($responseData, 200);
            }


        }catch (\Exception $e) { 
            DB::rollBack();
            //  dd($e->getMessage().'->'.$e->getLine());
            
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }

    public function updatePassword(Request $request){
        $userId = auth()->user()->id;

        $validatedData['old_password'] = ['required', 'string','min:8',new MatchOldPassword];
        $validatedData['new_password'] =  ['required', 'string', 'min:8', 'different:old_password'];
        $validatedData['confirm_password'] = ['required','min:8','same:new_password'];
        
        $request->validate($validatedData,[
            'confirm_password.same' => 'The confirm password and new password must match.'
        ]);

        DB::beginTransaction();
        try {
            $updateRecords['password'] = Hash::make($request->new_password);

            $updatedUserRecord = User::find($userId)->update($updateRecords);

            DB::commit();

            if($updatedUserRecord){
                //Return Success Response
                $responseData = [
                    'status'        => true,
                    'message'       => 'Password Changed Successfully!',
                ];

                return response()->json($responseData, 200);
            }


        }catch (\Exception $e) { 
            DB::rollBack();
            //  dd($e->getMessage().'->'.$e->getLine());
            
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
