@extends('emails.layouts.admin')

@section('email-content')
    @php
        $mailContent  = null;

        // $mailContent  = getSetting('booked_seminar_mail_content');
        // $mailContent  = str_replace('[NAME]',ucwords($name),$mailContent);
        // $mailContent  = str_replace('[EMAIL]',ucwords($email),$mailContent);
        // $mailContent  = str_replace('[SUPPORT_EMAIL]', getSetting('support_email'), $mailContent);
        // $mailContent  = str_replace('[SUPPORT_PHONE]', getSetting('support_phone'), $mailContent);
        // $mailContent  = str_replace('[APP_NAME]', config('app.name'), $mailContent);

    @endphp

    @if($mailContent)
         {!! $mailContent !!}
    @else

        <tr>
            <td>
                <p class="mail-title" style="font-size:14px;">
                    <b>Hello</b> {{ ucwords($name) }},
                </p>
                <div class="mail-desc">
                    <p style="font-size:14px;">Congratulations! Your recent purchase of seminar tickets has been successfully completed. We're thrilled to have you join us at {{$seminar->title ?? null}}!
                    </p>
                    <p style="font-size:14px;">Here are the details of your ticket:</p>
                    <div class="mail-desc">
                        <ul>
                            <li style="font-size:14px;">Booking Number : {{ $bookingNumber }}</li>

                            <li style="font-size:14px;">Event : {{ $seminar->title }}</li>
                            <li style="font-size:14px;">Datetime : {{ convertDateTimeFormat($seminar->start_date.' '.$seminar->start_time,'fulldatetime') .'-'. \Carbon\Carbon::parse($seminar->end_time)->format('h:i A') }}</li>
                            <li style="font-size:14px;">Venue : {{ $seminar->venue }}</li>
                          
                        </ul>
                    </div>
                </div>
            </td>
        
            <tr>
                <td>
                    <p style="font-size:14px;">
                        If you have any questions or need assistance, our support team is always here to help. Don't hesitate to reach out by replying to this email or visiting our support section on the website.
                        please contact us at {{ getSetting('support_email') ? getSetting('support_email') : config('constants.support_email') }} or {{ getSetting('support_phone') ? getSetting('support_phone') : config('constants.support_phone') }}
                    </p>

                </td>
            </tr>

            <tr>
                <td>
                    <p style="font-size:14px;">Best regards,</p>
                    <p style="font-size:14px;">{{ config('app.name') }}</p>
                </td>
            </tr>
        </tr>
    
    @endif

@endsection
