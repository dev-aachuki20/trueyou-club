<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)
                        @include('livewire.admin.seminar.form')
                    @elseif($viewMode)
                        @livewire('admin.seminar.show', ['seminar_id' => $seminar_id])
                    @elseif($bookingMode)
                        @livewire('admin.seminar.bookings-table', ['seminar_id' => $seminar_id])
                    @else
                    <div wire:loading wire:target="create" class="loader"></div>
                    <div class="card-title top-box-set">
                        <h4 class="card-title-heading">@lang('cruds.seminar.title') @lang('global.list') </h4>
                        <div class="card-top-box-item">
                            @can('seminar_create')
                            <button wire:click="create()" type="button" class="btn joinBtn btn-sm btn-icon-text btn-header">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.73956 14.3355C8.55177 14.5232 8.2948 14.6418 7.99829 14.6418C7.42503 14.6418 6.95062 14.1674 6.95062 13.5942L6.95062 2.40586C6.95062 1.8326 7.42503 1.35819 7.99828 1.35819C8.57154 1.35819 9.04595 1.8326 9.04595 2.40586L9.04595 13.5942C9.05584 13.8808 8.92735 14.1477 8.73956 14.3355Z" fill="#0A2540" />
                                    <path d="M14.3337 8.74129C14.1459 8.92908 13.889 9.04769 13.5924 9.04769L2.40412 9.04769C1.83087 9.04769 1.35645 8.57327 1.35645 8.00002C1.35645 7.42676 1.83087 6.95235 2.40412 6.95235L13.5924 6.95235C14.1657 6.95235 14.6401 7.42676 14.6401 8.00002C14.6401 8.29653 14.5215 8.5535 14.3337 8.74129Z" fill="#0A2540" />
                                </svg>
                                {{__('global.add')}}
                            </button>
                            @endcan
                        </div>
                    </div>
                    <div class="search-table-data">

                        @livewire('admin.seminar.seminar-table')

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />

<link rel="stylesheet" href="{{ asset('admin/assets/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    document.addEventListener('loadPlugins', function(event) {
        $('input[id="start_date"]').daterangepicker({
            autoApply: true,
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            minDate: new Date(),
            locale: {
                format: 'DD-MM-YYYY'
            },
        },
        function(start, end, label) {
            @this.set('start_date', start.format('YYYY-MM-DD'));

            @this.set('start_time', null);
            @this.set('end_time', null);

            var now = moment();
            if (start.isSame(now, 'day')) {
                UpdateStartTime(moment().startOf('hour').minute(moment().minute()))
            } else {
                UpdateStartTime(moment().startOf('day'))
            }
        });

        if(event.detail.updateMode){
            var fullStTime = new Date(event.detail.full_start_time);
            var fullEtTime = new Date(event.detail.full_end_time);
            
            UpdateStartTime(moment(fullStTime).startOf('day'), 'update_form');
            UpdateEndTime(moment(fullStTime).startOf('hour').minute(moment(fullStTime).minute()), 'update_form');

            $('#start_time').data('daterangepicker').setStartDate(fullStTime);
            $('#end_time').data('daterangepicker').setStartDate(fullEtTime);
        } else {
            UpdateStartTime(moment().startOf('hour').minute(moment().minute()), 'initial');
        }

        $('.dropify').dropify();
        $('.dropify-errors-container').remove();
        $('.dropify-clear').click(function(e) {
            e.preventDefault();
            var elementName = $(this).siblings('input[type=file]').attr('id');
            if (elementName == 'dropify-image') {
                @this.set('image', null);
                @this.set('originalImage', null);
                @this.set('removeImage', true);
            }
        });
    });

    document.addEventListener('seminarCounterEvent', function(event) {
        seminarCounter();
    });

    seminarCounter();

    function seminarCounter() {
        $(".webinar-item-active").each(function(index, element) {
            var totalSeconds = $(this).data('diff_in_seconds');

            const countdownInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    // Countdown has reached zero
                    clearInterval(countdownInterval);
                    var startdate = $(this).attr("data-conteststartDate");
                    var conteststatus = $(this).attr("data-contest-status");

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


    document.addEventListener('openTicketModal', function(event) {
        $('#ticketBox').modal('show');
    });

    document.addEventListener('closeTicketModal', function(event) {
        $('#ticketBox').modal('hide');
    });

    // Start Time
    function UpdateStartTime(time, type='picker_update'){
        if(type == 'picker_update'){
            $('#start_time').data('daterangepicker').remove();
        }
        $('#start_time').daterangepicker({
            autoApply: true,
            timePicker: true,
            timePicker24Hour: false,
            singleDatePicker: true,
            autoUpdateInput: false,
            minDate: time,
            startDate: time,
            locale: {
                format: 'hh:mm A'
            }
        }).on('apply.daterangepicker', function(ev, picker) {
            @this.set('start_time', picker.startDate.format('HH:mm'));
            @this.set('end_time', null);
            console.log(picker.startDate)
            if (picker.startDate) {
                UpdateEndTime(moment(picker.startDate).startOf('hour').minute(moment(picker.startDate).minute()));
            } else {
                UpdateEndTime(moment().startOf('day'));
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
        if(type != 'update_form'){
            UpdateEndTime(time, type);
        }
        
    }

    // End Time
    function UpdateEndTime(time, type='picker_update'){
        time.add(1, 'minutes');
        if(type == 'picker_update'){
            $('#end_time').data('daterangepicker').remove();
        }
        $('#end_time').daterangepicker({
            autoApply: true,
            timePicker: true,
            timePicker24Hour: false,
            singleDatePicker: true,
            autoUpdateInput: false,
            minDate: time,
            locale: {
                format: 'hh:mm A'
            }
        }).on('apply.daterangepicker', function(ev, picker) {
            @this.set('end_time', picker.startDate.format('HH:mm'));
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    }

</script>
@endpush