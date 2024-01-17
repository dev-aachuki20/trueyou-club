@extends('emails.layouts.admin')

@section('email-content')
    @php
        $mailContent  = getSetting('welcome_mail_content');
        $mailContent  = str_replace('[NAME]',ucwords($name),$mailContent);
        $mailContent  = str_replace('[EMAIL]',ucwords($email),$mailContent);
        // $mailContent  = str_replace('[PASSWORD]',ucwords($password),$mailContent);
        $mailContent  = str_replace('[SUPPORT_EMAIL]', getSetting('support_email'), $mailContent);
        $mailContent  = str_replace('[SUPPORT_PHONE]', getSetting('support_phone'), $mailContent);
        $mailContent  = str_replace('[APP_NAME]', config('app.name'), $mailContent);
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
                    <p style="font-size:14px;">Congratulations and welcome to {{ config('app.name') }}! We are thrilled to have you on board and look forward to your success in our program. This email serves as a confirmation of your successful registration.
                    </p>
                    <p style="font-size:14px;">Here your credentials:</p>
                    <div class="mail-desc">
                        <ul>
                            <li style="font-size:14px;">Email : {{ $email }}</li>
                            {{-- <li style="font-size:14px;">Password : {{ $password }}</li> --}}
                        </ul>
                    </div>
                </div>
            </td>
        
            <tr>
                <td>
                    <p style="font-size:14px;">Feel free to explore our MLM platform, where you can:</p>
                    <div class="mail-desc">
                        <ul>
                            <li style="font-size:14px;">Access your personalized dashboard.</li>
                            <li style="font-size:14px;">Explore available products and services.</li>
                            <li style="font-size:14px;">Connect with your upline and downline members.</li>
                            <li style="font-size:14px;">Attend training sessions and webinars.</li>
                            <li style="font-size:14px;">Track your earnings and commission.</li>

                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:14px;">
                        If you have any questions or need assistance, our support team is always here to help. Don't hesitate to reach out by replying to this email or visiting our support section on the website.
                        please contact us at {{ getSetting('support_email') ? getSetting('support_email') : config('constants.support_email') }} or {{ getSetting('support_phone') ? getSetting('support_phone') : config('constants.support_phone') }}
                    </p>
                    
                    <p style="font-size:14px;">We wish you great success in your MLM journey and hope you achieve your goals and dreams with our program. Remember, your success is our success!</p>

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
