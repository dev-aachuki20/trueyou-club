@extends('emails.layouts.admin')

@section('email-content')
    @php
        $mailContent  = getSetting('passcode_mail_content');
        $mailContent  = str_replace('[NAME]',ucwords($name),$mailContent);
        $mailContent  = str_replace('[PASSCODE]',ucwords($passcode),$mailContent);
        $mailContent  = str_replace('[SITE_URL]',config('constants.front_end_url').'register',$mailContent);
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
                    <p style="font-size:14px;">
                        Thank you for your interest in {{ config('app.name') }}! We're excited to have you onboard as a guest user.
                    </p>

                    <p style="font-size:14px;">To access all the features and benefits of {{ config('app.name') }}, you'll need to complete your registration using the unique passcode we've provided:</p>
                    <div class="mail-desc">
                            <p style="font-size:14px;"><span style="width:100%;box-sizing: border-box;line-height: 1.5em;margin-top: 0;margin: 0;background-color: #212529;padding: 9px 10px;text-align: center;font-size: 14px;font-weight: 400;font-family: 'Nunito Sans',sans-serif;color: #fff;display: inline-block;">{{ $passcode }}</span></p>
                            <p style="font-size:14px;">Url : <a href="{{ config('constants.front_end_url').'register' }}">{{ config('constants.front_end_url').'register' }}</a></p>
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
