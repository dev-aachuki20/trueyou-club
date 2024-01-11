<div>
    <div class="relative">

    @include('admin.partials.table-show-entries-search-box',['searchBoxPlaceholder'=>$searchBoxPlaceholder])
       
    <div class="quotes-listing">
        @if($allQuote->count() > 0)
        <ul>
            @foreach($allQuote as $serialNo => $quote)
            <li>
                <div class="webinar-item">
                    <p class="quotes-content">
                        {!! nl2br(e($quote->message)) !!}
                    </p>
                    <span class="quotes-date">
                        <svg width="14" height="15" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.66683 2.33337H2.25016C1.7439 2.33337 1.3335 2.74378 1.3335 3.25004V9.66671C1.3335 10.173 1.7439 10.5834 2.25016 10.5834H8.66683C9.17309 10.5834 9.5835 10.173 9.5835 9.66671V3.25004C9.5835 2.74378 9.17309 2.33337 8.66683 2.33337Z" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M7.2915 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M3.62549 1.41675V3.25008" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M1.3335 5.08337H9.5835" stroke="#878787" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        {{ convertDateTimeFormat($quote->created_at,'fulldate') }}
                    </span>
                    <div class="update-webinar">
                        <ul class="d-flex">
                            @can('quote_delete')
                            <li>
                                <a href="javascript:void()" wire:click.prevent="$emitUp('delete', {{$quote->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20">
                                        <path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"></path>
                                        <path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"></path>
                                        <path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"></path>
                                    </svg>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
            @include('admin.partials.no-record-found')
        @endif
    </div>
    {{ $allQuote->links('vendor.pagination.custom-pagination') }}
</div>

</div>