<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    public function getPageDetails($slug)
    {
        try {
            $record = Page::select('id', 'title', 'subtitle', 'button')->where('slug', $slug)->first();

            if ($record) {

                $pageRecords['title'] = $record->title;
                $pageRecords['subtitle'] = $record->subtitle;
                $pageRecords['button'] = $record->button;

                $imageUrl = $record->image_url ? $record->image_url : asset(config('constants.default.no_image'));

                $pageRecords['image_url'] = $imageUrl;

                $responseData = [
                    'status'  => true,
                    'data'    => $pageRecords,
                ];
                return response()->json($responseData, 200);
            } else {

                $responseData = [
                    'status'  => false,
                    'data'    => $record,
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
