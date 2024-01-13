<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;


class PostController extends Controller
{
    public function index($postType)
    {

        try {

            $postType = explode('-',$postType);
            
            $getAllRecords = Post::select(['title','content','type','publish_date'])->whereIn('type',$postType)->paginate(10);

            if ($getAllRecords->count() > 0) {

                foreach($getAllRecords as $record){
                    $record->slug = $record->encrypt_slug;
                    $record->publish_date = convertDateTimeFormat($record->start_date . ' ' . $record->start_time, 'fulldate');
                    
                    if($record->type == 'blog'){

                        $record->image_url = $record->blog_image_url ? $record->blog_image_url : asset(config('constants.default.no_image'));
                       
                    }else if($record->type == 'news'){

                        $record->image_url = $record->news_image_url ? $record->news_image_url : asset(config('constants.default.no_image'));
                      
                    }else if($record->type == 'health'){

                        $record->image_url = $record->health_image_url ? $record->health_image_url : asset(config('constants.default.no_image'));
    
                    }
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

    public function show($slug){

        $hasedValue = last(explode('-',$slug));

        dd($hasedValue);
        try {
            $record = Post::select(['title','content','publish_date'])->where('id',$decryptedId)->first();

            if($record){
           
                $record->publish_date = convertDateTimeFormat($record->start_date . ' ' . $record->start_time, 'fulldate');
                
                if($record->type == 'blog'){

                    $record->image_url = $record->blog_image_url ? $record->blog_image_url : asset(config('constants.default.no_image'));
                    
                }else if($record->type == 'news'){

                    $record->image_url = $record->news_image_url ? $record->news_image_url : asset(config('constants.default.no_image'));
                    
                }else if($record->type == 'health'){

                    $record->image_url = $record->health_image_url ? $record->health_image_url : asset(config('constants.default.no_image'));

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
