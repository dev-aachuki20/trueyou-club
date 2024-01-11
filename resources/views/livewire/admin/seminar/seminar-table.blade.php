<div>
    @include('admin.partials.table-show-entries-search-box',['searchBoxPlaceholder'=>$searchBoxPlaceholder])

    <div class="webinar_listing">
        <div class="row">
            @if($allSeminar->count() > 0)
            @foreach($allSeminar as $serialNo => $seminar)
            @php
            $date = $seminar->start_date;
            $time = $seminar->start_time;
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);

            $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $seminar->end_date . ' ' . $seminar->end_time);

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
                <div class="col-12 col-md-6">
                    <div class="webinar-item {{ $endDateTime < $now ? 'webinar-disabled' : '' }} {{ $diffInSeconds > 0 ? 'webinar-item-active' : '' }}" data-diff_in_seconds="{{ $diffInSeconds }}">
                        <div class="webinar-item-inner">

                            @if($endDateTime < $now) <div class="buyer-active-verfiy"><span>Expired Seminar </span></div>
                        @endif

                        <div class="webinar-img">
                            <img class="img-fluid" src="{{ $seminar->image_url ? $seminar->image_url : asset(config('constants.default.no_image')) }}" alt="">
                        </div>
                        <div class="webinar-content">
                            <h3>
                                {{ ucwords($seminar->title) }}
                            </h3>

                            <div class="date-time d-flex">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 12.3988C8.63627 12.3988 7.11377 10.885 7.11377 9.01251C7.11377 7.14001 8.63627 5.63501 10.5 5.63501C12.3638 5.63501 13.8863 7.14876 13.8863 9.02126C13.8863 10.8938 12.3638 12.3988 10.5 12.3988ZM10.5 6.94751C9.36252 6.94751 8.42627 7.87501 8.42627 9.02126C8.42627 10.1675 9.35377 11.095 10.5 11.095C11.6463 11.095 12.5738 10.1675 12.5738 9.02126C12.5738 7.87501 11.6375 6.94751 10.5 6.94751Z" fill="#DA7821" />
                                    <path d="M10.5 19.915C9.20497 19.915 7.90122 19.425 6.88622 18.4537C4.30497 15.9687 1.45247 12.005 2.52872 7.28875C3.49997 3.01 7.23622 1.09375 10.5 1.09375C10.5 1.09375 10.5 1.09375 10.5087 1.09375C13.7725 1.09375 17.5087 3.01 18.48 7.2975C19.5475 12.0137 16.695 15.9687 14.1137 18.4537C13.0987 19.425 11.795 19.915 10.5 19.915ZM10.5 2.40625C7.95372 2.40625 4.68122 3.7625 3.81497 7.5775C2.86997 11.6987 5.45997 15.2512 7.80497 17.5C9.31872 18.9612 11.69 18.9612 13.2037 17.5C15.54 15.2512 18.13 11.6987 17.2025 7.5775C16.3275 3.7625 13.0462 2.40625 10.5 2.40625Z" fill="#DA7821" />
                                </svg>
                                <span>
                                    {{ ucwords($seminar->venue) }}
                                </span>
                            </div>

                            <span class="quotes-date seminar-date">
                                <svg width="14" height="15" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.66683 2.33337H2.25016C1.7439 2.33337 1.3335 2.74378 1.3335 3.25004V9.66671C1.3335 10.173 1.7439 10.5834 2.25016 10.5834H8.66683C9.17309 10.5834 9.5835 10.173 9.5835 9.66671V3.25004C9.5835 2.74378 9.17309 2.33337 8.66683 2.33337Z" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.2915 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3.62549 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M1.3335 5.08337H9.5835" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                {{ convertDateTimeFormat($seminar->start_date.' '.$seminar->start_time,'fulldatetime') }}
                            </span>

                            {{-- <a href="{{ $seminar->meeting_link }}" class="btn btn-primary joinBtn">
                            Join The Seminar
                            </a> --}}
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
                    </div>
                    <div class="update-webinar">
                        <ul class="d-flex">
                            @can('seminar_edit')
                            @if($endDateTime > $now)
                            <li>
                                <a href="javascript:void()" wire:click.prevent="$emitUp('edit', {{$seminar->id}})">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5003 18.9583H7.50033C2.97533 18.9583 1.04199 17.025 1.04199 12.5V7.49996C1.04199 2.97496 2.97533 1.04163 7.50033 1.04163H9.16699C9.50866 1.04163 9.79199 1.32496 9.79199 1.66663C9.79199 2.00829 9.50866 2.29163 9.16699 2.29163H7.50033C3.65866 2.29163 2.29199 3.65829 2.29199 7.49996V12.5C2.29199 16.3416 3.65866 17.7083 7.50033 17.7083H12.5003C16.342 17.7083 17.7087 16.3416 17.7087 12.5V10.8333C17.7087 10.4916 17.992 10.2083 18.3337 10.2083C18.6753 10.2083 18.9587 10.4916 18.9587 10.8333V12.5C18.9587 17.025 17.0253 18.9583 12.5003 18.9583Z" fill="#40658B" />
                                        <path d="M7.08311 14.7417C6.57478 14.7417 6.10811 14.5584 5.76645 14.225C5.35811 13.8167 5.18311 13.225 5.27478 12.6L5.63311 10.0917C5.69978 9.60838 6.01645 8.98338 6.35811 8.64172L12.9248 2.07505C14.5831 0.416716 16.2664 0.416716 17.9248 2.07505C18.8331 2.98338 19.2414 3.90838 19.1581 4.83338C19.0831 5.58338 18.6831 6.31672 17.9248 7.06672L11.3581 13.6334C11.0164 13.975 10.3914 14.2917 9.90811 14.3584L7.39978 14.7167C7.29145 14.7417 7.18311 14.7417 7.08311 14.7417ZM13.8081 2.95838L7.24145 9.52505C7.08311 9.68338 6.89978 10.05 6.86645 10.2667L6.50811 12.775C6.47478 13.0167 6.52478 13.2167 6.64978 13.3417C6.77478 13.4667 6.97478 13.5167 7.21645 13.4834L9.72478 13.125C9.94145 13.0917 10.3164 12.9084 10.4664 12.75L17.0331 6.18338C17.5748 5.64172 17.8581 5.15838 17.8998 4.70838C17.9498 4.16672 17.6664 3.59172 17.0331 2.95005C15.6998 1.61672 14.7831 1.99172 13.8081 2.95838Z" fill="#40658B" />
                                        <path d="M16.5413 8.19173C16.483 8.19173 16.4246 8.1834 16.3746 8.16673C14.183 7.55006 12.4413 5.8084 11.8246 3.61673C11.733 3.2834 11.9246 2.94173 12.258 2.84173C12.5913 2.75006 12.933 2.94173 13.0246 3.27506C13.5246 5.05006 14.933 6.4584 16.708 6.9584C17.0413 7.05006 17.233 7.40006 17.1413 7.7334C17.0663 8.01673 16.8163 8.19173 16.5413 8.19173Z" fill="#40658B" />
                                    </svg>
                                </a>
                            </li>
                            @endif
                            @endcan

                            @can('seminar_delete')
                            <li>
                                <a href="javascript:void()" wire:click.prevent="$emitUp('delete', {{$seminar->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20">
                                        <path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B" />
                                        <path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B" />
                                        <path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B" />
                                    </svg>
                                </a>
                            </li>
                            @endcan

                            @can('seminar_show')
                            @if($endDateTime > $now)
                            <li>
                                <a href="javascript:void()" wire:click.prevent="$emitUp('show', {{$seminar->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20">
                                        <g id="_01_align_center" data-name="01 align center">
                                            <path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B" />
                                            <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B" />
                                        </g>
                                    </svg>
                                </a>
                            </li>
                            @endif
                            @endcan
                        </ul>
                    </div>
                </div>
        </div>
        @endforeach
        @else
        @include('admin.partials.no-record-found')
        @endif
    </div>
    {{ $allSeminar->links('vendor.pagination.custom-pagination') }}
</div>

</div>