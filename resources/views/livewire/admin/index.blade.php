<div class="content-wrapper dashboard-wrapper">
   <div class="row grid-margin Webinars-main">
      <div class="card">
         <div class="card-body">
            <div class="card-title top-box-set mb-5">
               <h4 class="card-title-heading blog-title mb-0">Webinars List </h4>
               <div class="card-top-box-item">
                  <button type="button" class="btn joinBtn btn-sm btn-icon-text btn-header">
                     <a href="{{route('admin.webinars')}}" class="text-decoration-none" target="_blank">
                        View all
                     </a>
                  </button>
               </div>
            </div>
            <div class="search-table-data">

               <div wire:id="aqDNFdUFBHb5vmCyHHVx">
                  <!-- End Show entries & Search box -->
                  <div class="webinar_listing">
                     <div class="row">
                        @if($webinar)
                        @php
                        $date = $webinar->start_date;
                        $time = $webinar->start_time;
                        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);

                        $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date .' '.$webinar->end_time);

                        $now = now();
                        $startWebinarTime = \Carbon\Carbon::parse($dateTime);

                        $startDays = 0;
                        $startHours = 0;
                        $startMinutes = 0;
                        $startSeconds = 0;
                        $diffInSeconds = 0;

                        if($now < $startWebinarTime){ $timeDiff=$now->diff($startWebinarTime);
                           $diffInSeconds=$now->diffInSeconds($startWebinarTime);
                           $startDays = $timeDiff->days;
                           $startHours = $timeDiff->h;
                           $startMinutes = $timeDiff->i;
                           $startSeconds = $timeDiff->s;
                           }
                           @endphp
                           <div class="col-12 col-md-12">
                              <div class="webinar-item  {{ $endDateTime < $now ? 'webinar-disabled' : '' }} {{ $diffInSeconds > 0 ? 'webinar-item-active' : '' }}" data-diff_in_seconds="{{$diffInSeconds}}">
                                 <div class="webinar-item-inner">
                                    @if($endDateTime < $now) <div class="buyer-active-verfiy"><span>Expired Seminar </span></div>
                                 @endif
                                 <div class="webinar-img">
                                    <img class="img-fluid" src="{{ $webinar->image_url ? $webinar->image_url : asset(config('constants.default.no_image')) }}" alt="">
                                 </div>
                                 <div class="webinar-content">
                                    <h3>
                                       {{ucwords($webinar->title) ?? ''}}
                                    </h3>
                                    <div class="date-time d-flex">
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
                                          {{ convertDateTimeFormat($webinar->start_date.' '.$webinar->start_time,'fulldatetime') }} - {{ \Carbon\Carbon::parse($webinar->end_time)->format('h:i A') }}
                                       </span>
                                    </div>
                                    <a href="{{ $endDateTime < $now ? 'javascript:void(0)' : $webinar->meeting_link }}" class="btn btn-primary joinBtn mt-3 {{ $diffInSeconds != 0 ? 'd-none' : '' }}">
                                       Join The Webinar
                                    </a>

                                    @if($diffInSeconds != 0)
                                    <div class="webinar-time-system webinar-time-{{ $webinar->id }} counter-main  {{ $diffInSeconds == 0 ? 'd-none' : '' }}">

                                       <div class="time-item counter-outer" data-label="days" data-value="{{ $startDays }}">
                                          <b class="counter">{{ $startDays }}</b><span>Days</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="hours" data-value="{{ $startHours }}">
                                          <b class="counter">{{ $startHours }}</b><span>Hours</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="minutes" data-value="{{ $startMinutes }}">
                                          <b class="counter">{{ $startMinutes }}</b><span>Minute</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="seconds" data-value="{{ $startSeconds }}">
                                          <b class="counter">{{ $startSeconds }}</b><span>Second</span>
                                       </div>
                                    </div>
                                    @endif

                                 </div>
                              </div>
                           </div>
                     </div>
                     @endif

                  </div>

               </div>

            </div>
            <!-- Livewire Component wire-end:aqDNFdUFBHb5vmCyHHVx -->
         </div>

      </div>
   </div>
   <!-- end webinar  -->


   <div class="card">
      <div class="card-body">
         <div class="card-title top-box-set mb-5">
            <h4 class="card-title-heading blog-title mb-0">Seminars List</h4>
            <div class="card-top-box-item">
               <button type="button" class="btn joinBtn btn-sm btn-icon-text btn-header">
                  <a href="{{route('admin.seminars')}}" class="text-decoration-none" target="_blank">
                     View all
                  </a>
               </button>
            </div>
         </div>
         <div class="search-table-data">

            <div wire:id="aqDNFdUFBHb5vmCyHHVx">
               <!-- End Show entries & Search box -->
               <div class="webinar_listing seminar-tab-list">
                  @if($seminar)
                  @php
                  $date = $seminar->start_date;
                  $time = $seminar->start_time;
                  $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);

                  $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .$seminar->end_time);

                  $now = now();
                  $startSeminarTime = \Carbon\Carbon::parse($dateTime);

                  $startDays = 0;
                  $startHours = 0;
                  $startMinutes = 0;
                  $startSeconds = 0;
                  $diffInSeconds = 0;
                  if($now < $startSeminarTime){ $timeDiff=$now->diff($startSeminarTime);
                     $diffInSeconds = $now->diffInSeconds($startSeminarTime);

                     $startDays = $timeDiff->days;
                     $startHours = $timeDiff->h;
                     $startMinutes = $timeDiff->i;
                     $startSeconds = $timeDiff->s;
                     }
                     @endphp
                     <ul class="row-list">
                        <li class="col-list">
                           <div class="webinar-item  {{ $endDateTime < $now ? 'webinar-disabled' : '' }} {{ $diffInSeconds > 0 ? 'webinar-item-active' : '' }}" data-diff_in_seconds="{{ $diffInSeconds }}">
                              <div class="webinar-item-inner seminar-wrapper">
                                 
                                 @if($endDateTime < $now) <div class="buyer-active-verfiy"><span>Expired Seminar </span></div>
                              @endif

                              <div class="webinar-img">
                                 <img class="img-fluid" src="{{ $seminar->image_url ? $seminar->image_url : asset(config('constants.default.no_image')) }}" alt="">
                              </div>
                              <div class="webinar-content">
                                 <div class="webinar-left">
                                    <h3>
                                       {{ucwords($seminar->title) ?? ''}}
                                    </h3>

                                    <div class="date-time d-flex">
                                       <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M10.5 12.3988C8.63627 12.3988 7.11377 10.885 7.11377 9.01251C7.11377 7.14001 8.63627 5.63501 10.5 5.63501C12.3638 5.63501 13.8863 7.14876 13.8863 9.02126C13.8863 10.8938 12.3638 12.3988 10.5 12.3988ZM10.5 6.94751C9.36252 6.94751 8.42627 7.87501 8.42627 9.02126C8.42627 10.1675 9.35377 11.095 10.5 11.095C11.6463 11.095 12.5738 10.1675 12.5738 9.02126C12.5738 7.87501 11.6375 6.94751 10.5 6.94751Z" fill="#DA7821"></path>
                                          <path d="M10.5 19.915C9.20497 19.915 7.90122 19.425 6.88622 18.4537C4.30497 15.9687 1.45247 12.005 2.52872 7.28875C3.49997 3.01 7.23622 1.09375 10.5 1.09375C10.5 1.09375 10.5 1.09375 10.5087 1.09375C13.7725 1.09375 17.5087 3.01 18.48 7.2975C19.5475 12.0137 16.695 15.9687 14.1137 18.4537C13.0987 19.425 11.795 19.915 10.5 19.915ZM10.5 2.40625C7.95372 2.40625 4.68122 3.7625 3.81497 7.5775C2.86997 11.6987 5.45997 15.2512 7.80497 17.5C9.31872 18.9612 11.69 18.9612 13.2037 17.5C15.54 15.2512 18.13 11.6987 17.2025 7.5775C16.3275 3.7625 13.0462 2.40625 10.5 2.40625Z" fill="#DA7821"></path>
                                       </svg>
                                       <span>
                                          {{ucwords($seminar->venue) ?? ''}}
                                       </span>
                                    </div>

                                    <span class="quotes-date seminar-date">
                                       <svg width="14" height="15" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M8.66683 2.33337H2.25016C1.7439 2.33337 1.3335 2.74378 1.3335 3.25004V9.66671C1.3335 10.173 1.7439 10.5834 2.25016 10.5834H8.66683C9.17309 10.5834 9.5835 10.173 9.5835 9.66671V3.25004C9.5835 2.74378 9.17309 2.33337 8.66683 2.33337Z" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M7.2915 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M3.62549 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M1.3335 5.08337H9.5835" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                       {{ convertDateTimeFormat($seminar->start_date.' '.$seminar->start_time,'fulldatetime') }} - {{ \Carbon\Carbon::parse($seminar->end_time)->format('h:i A') }}
                                    </span>

                                    @if($diffInSeconds != 0)
                                    <div class="webinar-time-system webinar-time-{{ $seminar->id }} counter-main">

                                       <div class="time-item counter-outer" data-label="days" data-value="{{ $startDays }}">
                                          <b class="counter">{{ $startDays }}</b><span>Days</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="hours" data-value="{{ $startHours }}">
                                          <b class="counter">{{ $startHours }}</b><span>Hours</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="minutes" data-value="{{ $startMinutes }}">
                                          <b class="counter">{{ $startMinutes }}</b><span>Minute</span>
                                       </div>:
                                       <div class="time-item counter-outer" data-label="seconds" data-value="{{ $startSeconds }}">
                                          <b class="counter">{{ $startSeconds }}</b><span>Second</span>
                                       </div>
                                    </div>
                                    @endif

                                 </div>
                                 <a href="javascript:voide(0);" class="btn btn-primary joinBtn book-seats">
                                    <span>
                                       0 / {{$seminar->total_ticket}}
                                    </span>
                                    Avilable Tickets
                                 </a>


                              </div>
                           </div>
               </div>
               </li>
               </ul>
               @endif


            </div>
         </div>
         <!-- Livewire Component wire-end:aqDNFdUFBHb5vmCyHHVx -->
      </div>

   </div>
</div>
<!-- end  -->
</div>

<div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         <div class="card-body">
            <div class="card-title top-box-set mb-5">
               <h4 class="card-title-heading blog-title mb-0">Quote of the day</h4>
               <!-- <div class="card-top-box-item">
                     <button type="button" class="btn joinBtn btn-sm btn-icon-text btn-header">
                           View all
                     </button>
                  </div> -->
            </div>
            @if($todaysQuote)
            <div class="qoute-listng">
               <div class="contnet-box">
                  <div class="qoute-item blur-qoute">
                     {{ucfirst($todaysQuote->message ?? '')}}
                  </div>
                  <span>
                     25% of people have completed their task few more to go!
                  </span>
               </div>
               <div class="img-box">
                  <img class="img-fluid" src="{{ asset('admin/images/quote-image.svg') }}" alt="">
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
<!-- end Quote -->

<div class="row lead-board">
   <div class="col-12 card">
      <div class="card-title">
         <h4 class="card-title-heading blog-title mb-0">Lead board</h4>
      </div>
      <div class="card-body mt-4">
         <ul>
            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board01.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board02.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board03.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board04.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board01.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board02.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board03.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board04.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board01.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board02.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board03.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>

            <li>
               <div class="content">
                  <div class="img-box">
                     <img class="img-fluid" src="{{ asset('admin/images/Lead-Board04.png') }}" alt="">
                  </div>
                  <div class="title">
                     Cameron Williamson
                  </div>
               </div>
               <div class="vip-box">
                  <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.3208 11.1356C12.3208 11.6076 11.9397 12 11.459 12H3.53953C3.06366 12 2.67773 11.6135 2.67773 11.1356C2.67773 10.6672 3.05699 10.2726 3.53953 10.2726H11.459C11.9349 10.2726 12.3208 10.6591 12.3208 11.1356Z" fill="url(#paint0_linear_277_10065)" />
                     <path d="M13.2584 4.91025L13.0892 5.3577L11.4137 9.79236L11.2317 10.2718H3.76685L3.58496 9.79236L1.90939 5.35773L1.74023 4.91029C1.99236 4.81438 2.20618 4.64181 2.35299 4.42125C2.4998 4.49636 2.64662 4.56188 2.79343 4.62101C4.32534 5.2139 5.85087 4.77763 6.8546 2.93024C6.9296 2.79442 6.9998 2.65059 7.06842 2.49878C7.20407 2.54673 7.34927 2.57228 7.49928 2.57228C7.65086 2.57228 7.79768 2.54673 7.93172 2.49878C8.00034 2.65059 8.07053 2.79445 8.14554 2.93024C9.15088 4.77925 10.6748 5.2139 12.2067 4.62101C12.3535 4.56188 12.5003 4.49636 12.6471 4.42125C12.794 4.64177 13.0062 4.81276 13.2584 4.91025Z" fill="url(#paint1_linear_277_10065)" />
                     <path d="M8.78459 1.28612C8.78459 1.99642 8.20965 2.57354 7.49908 2.57354C6.78982 2.57354 6.21484 1.99642 6.21484 1.28612C6.21484 0.575817 6.78982 0 7.49908 0C8.20965 3.51322e-05 8.78459 0.575817 8.78459 1.28612Z" fill="url(#paint2_linear_277_10065)" />
                     <path d="M2.56974 3.70632C2.56974 4.41662 1.99477 4.99374 1.28424 4.99374C0.574975 4.99374 0 4.41662 0 3.70632C0 2.99601 0.574975 2.4202 1.28424 2.4202C1.9948 2.4202 2.56974 2.99601 2.56974 3.70632Z" fill="url(#paint3_linear_277_10065)" />
                     <path d="M14.9994 3.70632C14.9994 4.41662 14.4245 4.99374 13.7139 4.99374C13.0047 4.99374 12.4297 4.41662 12.4297 3.70632C12.4297 2.99601 13.0047 2.4202 13.7139 2.4202C14.4245 2.4202 14.9994 2.99601 14.9994 3.70632Z" fill="url(#paint4_linear_277_10065)" />
                     <path d="M8.71391 7.19696C8.71391 8.16861 8.16977 8.95645 7.49955 8.95645C6.82933 8.95645 6.28516 8.16861 6.28516 7.19696C6.28516 6.22534 6.8293 5.43747 7.49955 5.43747C8.16977 5.43747 8.71391 6.22534 8.71391 7.19696Z" fill="url(#paint5_linear_277_10065)" />
                     <defs>
                        <linearGradient id="paint0_linear_277_10065" x1="7.49928" y1="12" x2="7.49928" y2="10.2726" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F9403E" />
                           <stop offset="1" stop-color="#F77953" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_277_10065" x1="7.49931" y1="10.2718" x2="7.49931" y2="2.49874" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_277_10065" x1="7.49971" y1="2.57354" x2="7.49971" y2="3.52803e-05" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_277_10065" x1="1.28487" y1="4.99374" x2="1.28487" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_277_10065" x1="13.7146" y1="4.99374" x2="13.7146" y2="2.4202" gradientUnits="userSpaceOnUse">
                           <stop stop-color="#F79808" />
                           <stop offset="1" stop-color="#EDBB0B" />
                        </linearGradient>
                        <linearGradient id="paint5_linear_277_10065" x1="7.49955" y1="8.95645" x2="7.49955" y2="5.43747" gradientUnits="userSpaceOnUse">
                           <stop offset="0.0168" stop-color="#CCCCCC" />
                           <stop offset="1" stop-color="#F2F2F2" />
                        </linearGradient>
                     </defs>
                  </svg>
                  VIP
               </div>

            </li>
         </ul>
      </div>
   </div>
</div>
</div>
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript">
   document.addEventListener('webinarCounterEvent', function(event) {
      webinarCounter();
   });

   webinarCounter();

   function webinarCounter() {
      $(".webinar-item-active").each(function(index, element) {
         var totalSeconds = $(this).data('diff_in_seconds');

         const countdownInterval = setInterval(() => {
            if (totalSeconds <= 0) {
               // Countdown has reached zero
               clearInterval(countdownInterval);

               $(this).find('.joinBtn').removeClass('d-none');

               $(this).find('.webinar-time-system').remove();
            } else {

               // Calculate days, hours, minutes, and seconds
               var days = Math.floor(totalSeconds / (24 * 60 * 60));
               var hours = Math.floor((totalSeconds % (24 * 60 * 60)) / (60 * 60));
               var minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
               var seconds = totalSeconds % 60;

               // Display the countdown
               $(this).find('.counter-outer[data-label = "days"] b.counter').text(days);
               $(this).find('.counter-outer[data-label = "hours"] b.counter').text(hours)
               $(this).find('.counter-outer[data-label = "minutes"] b.counter').text(minutes)
               $(this).find('.counter-outer[data-label = "seconds"] b.counter').text(seconds)

               // Decrement totalSeconds by 1
               totalSeconds--;
            }
         }, 1000);
      });
   }
</script>
@endpush