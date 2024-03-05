<?php

return [
    'userManagement' => [
        'title'          => 'User Management',
        'title_singular' => 'User Management',
    ],
    'setting' => [
        'title'          => 'Settings',
        'title_singular' => 'Setting',
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'first_name'               => 'First Name',
            'last_name'                => 'Last Name',
            'name'                     => 'Name',
            'full_name'                => 'Full name',
            'email'                    => 'Email',
            'phone'                    => 'Phone Number',
            'profile_image'            => 'Profile Image',
            'status'                   => 'Status',
            'password'                 => 'Password',
            'confirm_password'         => 'Password Confirm',
            'role'                     => 'User Level',
            'created_at'               => 'Created',
            'updated_at'               => 'Updated',
            'deleted_at'               => 'Deleted',
            'rating'                   => 'Rating',

        ],
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'title'             => 'Title',
            'created_at'        => 'Created at',
            'updated_at'        => 'Updated at',
            'deleted_at'        => 'Deleted at',
        ],
    ],


    'dashboard'  => [],

    'transaction' => [
        'title'                 => 'Transactions',
        'title_singular'        => 'Transaction',
        'fields' => [
            'user'   => 'User',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'payment_type'   => 'Payment Type',
            'payment_method' => 'Payment Method',
            'status'         => 'Status',
        ],
    ],

    'webinar' => [
        'title'                 => 'Webinars',
        'title_singular'        => 'Webinar',
        'fields' => [
            'title'   => 'Title',
            'start_date'    => 'Webinar Date',
            'start_time'    => 'Start Time',
            'end_date'      => 'End Date',
            'end_time'      => 'End Time',
            'meeting_link' => 'Meeting Link',
            'start_date_time'   => 'Start Datetime',
            'end_date_time'     => 'End Datetime',
            'join_meeting'      => 'Join The Webinar',
        ],
    ],

    'blog' => [
        'title'                 => 'Blogs',
        'title_singular'        => 'Blog',
        'fields' => [
            'title'   => 'Title',
            'content' => 'Content',
            'publish_date' => 'Publish Date'
        ],
    ],

    'news' => [
        'title'                 => 'News',
        'title_singular'        => 'News',
        'fields' => [
            'title'   => 'Title',
            'content' => 'Content',
            'publish_date' => 'Publish Date'
        ]
    ],

    'quote' => [
        'title'                 => 'Quotes',
        'title_singular'        => 'Quote',
        'fields' => [
            'message'   => 'Quote Message',

        ],
    ],

    'seminar' => [
        'title'                 => 'Seminars',
        'title_singular'        => 'Seminar',
        'fields' => [
            'title'         => 'Title',
            'total_ticket'  => 'Total Number of Tickets',
            'ticket_price'  => 'Ticket Price',
            'start_date'    => 'Seminar Date',
            'start_time'    => 'Start Time',
            'end_date'      => 'End Date',
            'end_time'      => 'End Time',
            'venue'         => 'Venue',
            'start_date_time'   => 'Start Datetime',
            'end_date_time'     => 'End Datetime',

        ],
    ],

    'health' => [
        'title'                 => 'Health',
        'title_singular'        => 'Health',
        'fields' => [
            'title'   => 'Title',
            'content' => 'Content',
            'publish_date' => 'Publish Date'
        ]
    ],

    'contacts' => [
        'title'                 => 'Contact Form',
        'title_singular'        => 'Contact',
        'fields' => [
            'full_name'   => 'Full Name',
            'first_name'   => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'message' => 'Message'
        ]
    ],

    'pages' => [
        'title'      => 'Pages',
        'title_singular' => 'Page',
        'fields' => [
            'page_name'   => 'Page Name',
            'page_name'   => 'Page Name',
            'title'   => 'Title',
            'subtitle'   => 'Sub Title',
            'description'   => 'Description',
            'button' => 'Button Title',
            'link' => 'Link',
        ]
    ],

    'sections' => [
        'title'          => 'Sections',
        'title_singular' => 'Section',
        'fields' => [
            'title'          => 'Title',
            'content_text'   => 'Content Text',
            'button'         => 'Button Title',
            'link'           => 'Link',
        ]
    ],

    'booking' => [
        'title'                 => 'Bookings',
        'title_singular'        => 'Booking',
        'fields' => [
            'seminar_name'    => 'Seminar Name',
            'user_name'       => 'Name',
            'user_email'      => 'Email',
            'booking_number'  => 'Booking Number',
            'bookings'  => 'B',
        ],
    ],

    'mis_reports' => [
        'title'=>'MIS Reports',
        'title_singular'=>'MIS Report',
        'fields'=>[
            'date' => 'Quote Date',
            'user_name' => 'User Name',
            'quote' => 'Quote',
            'total_skipped' => 'Total Skipped',
            'total_completed' => 'Total Completed',
            'total_leave' => 'Total Leave',
            'total_user' => 'Total User',
            'status' => 'Status',
        ]
    ]
];
