@extends('emails.layouts.admin')
<style>
.ticket-wrapper {
    background-color: #F5F7F9;
    padding: 1rem;
    border-radius: 10px;
}   
.ticketBooking-list ul {
    padding: 0;
}

.ticketBooking-list ul li {
    padding: 21px 0;
    border-bottom: 1px solid #DDDDE9;
}

.ticketBooking-inner {
    display: flex;
    align-items: center;
}

.ticketBooking-list ul li .ticketBooking-inner span {
    font-size: 14px;
    font-style: normal;
    font-weight: 300;
    width: 120px;
}

.ticketBooking-list ul li .ticketBooking-inner b{
    font-size: 14px;
    font-weight: 600;
}

.ticketBooking-inner .space {
    margin-right: 15px;
}

.total-box {
    padding: 20px;
    border-radius: 5px;
    background-color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.total-box .title {
    color: #0A2540;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
}

.total-box .total-amount {
    color: #23D21F;
    text-align: center;
    font-size: 20px;
    font-weight: 600;
}
</style>
@section('email-content')
    @php
        $mailContent  = null;

        $mailContent  = getSetting('booked_seminar_mail_content');
        
        $mailContent  = str_replace('[NAME]',ucwords($name),$mailContent);

        $mailContent  = str_replace('[BOOKING_NUMBER]',$bookingNumber,$mailContent);
        $mailContent  = str_replace('[SEMINAR_TITLE]',ucwords($seminar->title),$mailContent);
        $mailContent  = str_replace('[SEMINAR_DATE]',convertDateTimeFormat($seminar->start_date,'fulldate'),$mailContent);

        $mailContent  = str_replace('[SEMINAR_START_TIME]',\Carbon\Carbon::parse($seminar->start_time)->format('h:i A'),$mailContent);
        $mailContent  = str_replace('[SEMINAR_END_TIME]',\Carbon\Carbon::parse($seminar->end_time)->format('h:i A'),$mailContent);

        $mailContent  = str_replace('[SEMINAR_VENUE]',ucwords($seminar->venue),$mailContent);


        $mailContent  = str_replace('[SUPPORT_EMAIL]', getSetting('support_email'), $mailContent);
        $mailContent  = str_replace('[SUPPORT_PHONE]', getSetting('support_phone'), $mailContent);

        $mailContent  = str_replace('[APP_NAME]', config('app.name'), $mailContent);

    @endphp

    @if($mailContent)
         {!! $mailContent !!}
    @else

        <tr>
            <tr>
                <td>
                    <p class="mail-title" style="font-size:14px;">
                        <b>Hello</b> {{ ucwords($name) }},
                    </p>
                    <div class="mail-desc">
                        <p style="font-size:14px;">Congratulations! Your recent purchase of seminar tickets has been successfully completed. We're thrilled to have you join us at {{$seminar->title ?? null}}!
                        </p>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="ticket-wrapper">
                        <div class="webinar-item">
                            <div class="webinar-item-inner">
                                <div class="webinar-img">
                                    <img class="img-fluid" src="{{ $seminar->seminarImage->file_path ? asset('storage/'.$seminar->seminarImage->file_path) : asset(config('constants.default.no_image')) }}"" alt="{{$seminar->title ?? '' }}">
                                </div>
                                <div class="webinar-content">
                                <h3>
                                    {{ ucwords($seminar->title) }}
                                </h3>
                                <div class="date-time seminar-date d-flex">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 4.8125C5.6925 4.8125 5.4375 4.5575 5.4375 4.25V2C5.4375 1.6925 5.6925 1.4375 6 1.4375C6.3075 1.4375 6.5625 1.6925 6.5625 2V4.25C6.5625 4.5575 6.3075 4.8125 6 4.8125Z" fill="#DA7821"></path>
                                        <path d="M12 4.8125C11.6925 4.8125 11.4375 4.5575 11.4375 4.25V2C11.4375 1.6925 11.6925 1.4375 12 1.4375C12.3075 1.4375 12.5625 1.6925 12.5625 2V4.25C12.5625 4.5575 12.3075 4.8125 12 4.8125Z" fill="#DA7821"></path>
                                        <path d="M6.375 11.375C6.2775 11.375 6.18 11.3525 6.09 11.315C5.9925 11.2775 5.9175 11.225 5.8425 11.1575C5.7075 11.015 5.625 10.8275 5.625 10.625C5.625 10.5275 5.6475 10.43 5.685 10.34C5.7225 10.25 5.775 10.1675 5.8425 10.0925C5.9175 10.025 5.9925 9.97249 6.09 9.93499C6.36 9.82249 6.6975 9.88251 6.9075 10.0925C7.0425 10.235 7.125 10.43 7.125 10.625C7.125 10.67 7.1175 10.7225 7.11 10.775C7.1025 10.82 7.0875 10.865 7.065 10.91C7.05 10.955 7.0275 11 6.9975 11.045C6.975 11.0825 6.9375 11.12 6.9075 11.1575C6.765 11.2925 6.57 11.375 6.375 11.375Z" fill="#DA7821"></path>
                                        <path d="M9 11.375C8.9025 11.375 8.805 11.3525 8.715 11.315C8.6175 11.2775 8.5425 11.225 8.4675 11.1575C8.3325 11.015 8.25 10.8275 8.25 10.625C8.25 10.5275 8.2725 10.43 8.31 10.34C8.3475 10.25 8.4 10.1675 8.4675 10.0925C8.5425 10.025 8.6175 9.97249 8.715 9.93499C8.985 9.81499 9.3225 9.8825 9.5325 10.0925C9.6675 10.235 9.75 10.43 9.75 10.625C9.75 10.67 9.7425 10.7225 9.735 10.775C9.7275 10.82 9.7125 10.865 9.69 10.91C9.675 10.955 9.6525 11 9.6225 11.045C9.6 11.0825 9.5625 11.12 9.5325 11.1575C9.39 11.2925 9.195 11.375 9 11.375Z" fill="#DA7821"></path>
                                        <path d="M11.625 11.375C11.5275 11.375 11.43 11.3525 11.34 11.315C11.2425 11.2775 11.1675 11.225 11.0925 11.1575C11.0625 11.12 11.0325 11.0825 11.0025 11.045C10.9725 11 10.95 10.955 10.935 10.91C10.9125 10.865 10.8975 10.82 10.89 10.775C10.8825 10.7225 10.875 10.67 10.875 10.625C10.875 10.43 10.9575 10.235 11.0925 10.0925C11.1675 10.025 11.2425 9.97249 11.34 9.93499C11.6175 9.81499 11.9475 9.8825 12.1575 10.0925C12.2925 10.235 12.375 10.43 12.375 10.625C12.375 10.67 12.3675 10.7225 12.36 10.775C12.3525 10.82 12.3375 10.865 12.315 10.91C12.3 10.955 12.2775 11 12.2475 11.045C12.225 11.0825 12.1875 11.12 12.1575 11.1575C12.015 11.2925 11.82 11.375 11.625 11.375Z" fill="#DA7821"></path>
                                        <path d="M6.375 14C6.2775 14 6.18 13.9775 6.09 13.94C6 13.9025 5.9175 13.85 5.8425 13.7825C5.7075 13.64 5.625 13.445 5.625 13.25C5.625 13.1525 5.6475 13.055 5.685 12.965C5.7225 12.8675 5.775 12.785 5.8425 12.7175C6.12 12.44 6.63 12.44 6.9075 12.7175C7.0425 12.86 7.125 13.055 7.125 13.25C7.125 13.445 7.0425 13.64 6.9075 13.7825C6.765 13.9175 6.57 14 6.375 14Z" fill="#DA7821"></path>
                                        <path d="M9 14C8.805 14 8.61 13.9175 8.4675 13.7825C8.3325 13.64 8.25 13.445 8.25 13.25C8.25 13.1525 8.2725 13.055 8.31 12.965C8.3475 12.8675 8.4 12.785 8.4675 12.7175C8.745 12.44 9.255 12.44 9.5325 12.7175C9.6 12.785 9.6525 12.8675 9.69 12.965C9.7275 13.055 9.75 13.1525 9.75 13.25C9.75 13.445 9.6675 13.64 9.5325 13.7825C9.39 13.9175 9.195 14 9 14Z" fill="#DA7821"></path>
                                        <path d="M11.625 14C11.43 14 11.235 13.9175 11.0925 13.7825C11.025 13.715 10.9725 13.6325 10.935 13.535C10.8975 13.445 10.875 13.3475 10.875 13.25C10.875 13.1525 10.8975 13.055 10.935 12.965C10.9725 12.8675 11.025 12.785 11.0925 12.7175C11.265 12.545 11.5275 12.4625 11.7675 12.515C11.82 12.5225 11.865 12.5375 11.91 12.56C11.955 12.575 12 12.5975 12.045 12.6275C12.0825 12.65 12.12 12.6875 12.1575 12.7175C12.2925 12.86 12.375 13.055 12.375 13.25C12.375 13.445 12.2925 13.64 12.1575 13.7825C12.015 13.9175 11.82 14 11.625 14Z" fill="#DA7821"></path>
                                        <path d="M15.375 7.87997H2.625C2.3175 7.87997 2.0625 7.62497 2.0625 7.31747C2.0625 7.00997 2.3175 6.75497 2.625 6.75497H15.375C15.6825 6.75497 15.9375 7.00997 15.9375 7.31747C15.9375 7.62497 15.6825 7.87997 15.375 7.87997Z" fill="#DA7821"></path>
                                        <path d="M12 17.5625H6C3.2625 17.5625 1.6875 15.9875 1.6875 13.25V6.875C1.6875 4.1375 3.2625 2.5625 6 2.5625H12C14.7375 2.5625 16.3125 4.1375 16.3125 6.875V13.25C16.3125 15.9875 14.7375 17.5625 12 17.5625ZM6 3.6875C3.855 3.6875 2.8125 4.73 2.8125 6.875V13.25C2.8125 15.395 3.855 16.4375 6 16.4375H12C14.145 16.4375 15.1875 15.395 15.1875 13.25V6.875C15.1875 4.73 14.145 3.6875 12 3.6875H6Z" fill="#DA7821"></path>
                                    </svg>
                                    <span>
                                        {{ convertDateTimeFormat($seminar->start_date,'fulldate') }}
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="ticketBooking-list">
                            <ul>
                                <li>
                                    <div class="ticketBooking-inner"><span>Booking Number</span><div class="space">:</div><b>{{ $bookingNumber }}</b></div>
                                </li>
                                <li>
                                    <div class="ticketBooking-inner"><span>Seminar Time</span><div class="space">:</div><b>{{ \Carbon\Carbon::parse($seminar->start_time)->format('h:i A') }} To {{ \Carbon\Carbon::parse($seminar->end_time)->format('h:i A') }}</b></div>
                                </li>
                                <li>
                                    <div class="ticketBooking-inner"><span>Seminar Venue</span><div class="space">:</div><b>{{ ucwords($seminar->venue) }}</b></div>
                                </li>
                            </ul>
                            <div class="total-box">
                                <div class="title">
                                    Total Price
                                </div>
                                <div>:</div>
                                <div class="total-amount">
                                    ${{ number_format($seminar->ticket_price,2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
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
