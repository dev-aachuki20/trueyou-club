<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Request Type List
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the request type list 
    |
    */ 
    'app_name' => env('APP_NAME'),
    'front_end_url' => env('FRONTEND_URL'),
    'app_mode' => env('APP_MODE','staging'),
    'default' => [
        'logo' => 'images/logo.png',
        'favicon' => 'images/favicon.png',
        'admin_favicon' => 'images/fav-icon.svg',
        'short_logo' => 'images/favicon.png',
        'admin_logo' => 'images/logo.svg',
        'transparent_logo' => 'assets/logo/logo-transparent.png',
        'profile_image' => 'default/default-user.svg',
        'email_logo' => 'images/email-logo.png',
        'no_image' => 'default/no-image.jpg',
    ],

    'profile_image_size' =>'2048', // 1024 = 1 MB

    'owner_email' => env('OWNER_MAIL'),
    'twilio_country_code'=>env('TWILIO_COUNTRY_CODE'),
    'buyer_application_free_price_id'=>env('BUYER_APPLICATION_FEE_PRICE_ID'),
    'buyer_profile_update_price_id'=>env('BUYER_PROFILE_UPDATE_PRICE_ID'),

    // 'owner_email' => 'amitpandey.his@gmail.com',
    // 'owner_email' => 'rohithelpfullinsight@gmail.com',
    
    'date_format' => 'm/d/Y',
    'datetime_format' => 'm/d/Y h:i:s A',
    'search_datetime_format' => '%m/%d/%Y %H:%i',
    'search_date_format' => '%m/%d/%Y',
    'set_timezone' => 'Asia/kolkata', // set timezone
    
    'logo_min_width' => '250', // logo min width
    'logo_min_height' => '150', // logo min height
   
    'img_max_size' => '1024', // In KB
    'video_max_size' => '102400', // 102400 KB => 100MB

    'token_expired_time'=>60,

    'datatable_entries' => [10, 25, 50, 100],

    'number_of_rows' => [
        10 => '10',
        25 => '25',
        50 => '50',
        75 => '75',
        100 => '100',
    ],


    'default_currency' => env('DEFAULT_CURRENCY','usd'),
    'default_country' => 233,

];