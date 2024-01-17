<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\Seminar;
use Illuminate\Support\Carbon;

class CommanController extends Controller
{
   
    public function siteSettingDetails()
    {
        $setting_details = [
            'favicon'     =>  getSetting('favicon'),
            'site_logo'   =>  getSetting('site_logo'),
            'footer_logo' =>  getSetting('footer_logo'),
            'short_logo'  =>  getSetting('short_logo'),
            'support'     => getSettingByGroup('support'),
            'social_media' => getSettingByGroup('social media'),
        ];
        // Return response
        $responseData = [
            'status' => true,
            'data'   => $setting_details,
        ];
        return response()->json($responseData, 200);
    }

    public function getLatestRecords($pageName){
        try {
            $currentDateTime = Carbon::now();

            $latestRecords = null;
            if($pageName == 'login'){

                // Start Latest Seminar Details
                $latestSeminar = Seminar::where('start_date', '>=', $currentDateTime->toDateString())
                ->where(function ($query) use ($currentDateTime) {
                    $query->where('end_time', '>', $currentDateTime->toTimeString())
                        ->orWhere('start_date', '>', $currentDateTime->toDateString());
                })
                ->orderBy('start_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->limit(1)
                ->first();

              
                $latestRecords['seminar']['title'] = $latestSeminar->title;
                $latestRecords['seminar']['total_ticket'] = $latestSeminar->total_ticket;
                $latestRecords['seminar']['venue'] = $latestSeminar->venue;

                $latestRecords['seminar']['datetime'] = convertDateTimeFormat($latestSeminar->start_date.' '.$latestSeminar->start_time,'fulldatetime') .'-'. Carbon::parse($latestSeminar->end_time)->format('h:i A');

                $latestRecords['seminar']['image_url'] = $latestSeminar->image_url ? $latestSeminar->image_url : asset(config('constants.default.no_image'));
                // End Latest Seminar Details

                // Start Latest Blog Details
                $latestBlog = Post::where('type','blog')->orderBy('publish_date', 'desc')->limit(1)->first();

                $latestRecords['blog']['title']   = $latestBlog->title;
                $latestRecords['blog']['slug']    = $latestBlog->slug;
                $latestRecords['blog']['content'] = $latestBlog->content;
                $latestRecords['blog']['type']    = $latestBlog->type;

                $latestRecords['blog']['publish_date'] = convertDateTimeFormat($latestBlog->publish_date,'fulldate');

                $latestRecords['blog']['image_url'] = $latestBlog->blog_image_url ? $latestBlog->blog_image_url : asset(config('constants.default.no_image'));

                // End Latest Blog Details

                // Start Latest News Details
                $latestNews = Post::where('type','news')->orderBy('publish_date', 'desc')->limit(1)->first();

                $latestRecords['news']['title']   = $latestNews->title;
                $latestRecords['news']['slug']    = $latestNews->slug;
                $latestRecords['news']['content'] = $latestNews->content;
                $latestRecords['news']['type']    = $latestNews->type;

                $latestRecords['news']['publish_date'] = convertDateTimeFormat($latestNews->publish_date,'fulldate');

                $latestRecords['news']['image_url'] = $latestNews->news_image_url ? $latestNews->news_image_url : asset(config('constants.default.no_image'));

                // End Latest News Details


            }elseif($pageName == 'home'){
                // Start upcomming Seminar Details
                $upcomingSeminars = Seminar::select('id','title','venue','start_date','start_time','end_time')->where('start_date', '>=', $currentDateTime->toDateString())
                ->where(function ($query) use ($currentDateTime) {
                    $query->where('end_time', '>', $currentDateTime->toTimeString())
                        ->orWhere('start_date', '>', $currentDateTime->toDateString());
                })
                ->orderBy('start_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->limit(3)
                ->get();

                foreach($upcomingSeminars as $seminar){
                  
                    $seminar->datetime = convertDateTimeFormat($seminar->start_date.' '.$seminar->start_time,'fulldatetime') .'-'. Carbon::parse($seminar->end_time)->format('h:i A');
    
                    $seminar->image_url = $seminar->image_url ? $seminar->image_url : asset(config('constants.default.no_image'));
                }

                $latestRecords['upcomingSeminars'] = $upcomingSeminars;

                // End upcomming Seminar Details

                // Start Latest Post Details

                $latestPosts = Post::select('id','title','slug','content','publish_date','type')->whereIn('type',['blog','news'])->orderBy('publish_date', 'desc')->limit(3)->get();

                foreach($latestPosts as $post){
                  
                    $post->datetime = convertDateTimeFormat($post->publish_date,'fulldate');
    
                    if($post->type == 'blog'){
                        $post->image_url = $post->blog_image_url ? $post->blog_image_url : asset(config('constants.default.no_image'));
                    }elseif($post->type == 'news'){
                        $post->image_url = $post->news_image_url ? $post->news_image_url : asset(config('constants.default.no_image'));
                    }
                }

                $latestRecords['latestPosts'] = $latestPosts;

                // End Latest Post Details

            }

            // Return response
            $responseData = [
                'status' => true,
                'data'   => $latestRecords,
            ];
            return response()->json($responseData, 200);

        }catch (\Exception $e) { 
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