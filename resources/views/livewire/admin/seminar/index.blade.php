<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)

                    @include('livewire.admin.seminar.form')

                    @elseif($viewMode)

                    @livewire('admin.seminar.show', ['seminar_id' => $seminar_id])

                    @else
                    <div wire:loading wire:target="create" class="loader"></div>
                    <div class="card-title top-box-set">
                        <h4 class="card-title-heading">@lang('cruds.seminar.title') @lang('global.list') </h4>
                        <div class="card-top-box-item">
                            @can('seminar_create')
                            <button wire:click="create()" type="button" class="btn btn-sm btn-success btn-icon-text btn-header">
                                <i class="ti-plus btn-icon-prepend"></i>
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
<link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    document.addEventListener('loadPlugins', function(event) {

        $('input[id="seminar_time"]').daterangepicker({
            autoApply: true,
            timePicker: true,
            timePicker24Hour: false,
            singleDatePicker: true,
            timePickerIncrement: 15,
            // minDate: moment().startOf('day'),
            // maxDate: moment().startOf('day').add(12, 'hour'),
            locale: {
                format: 'hh:mm A'
            }

        }, function(start, end, label) {
            // Handle your apply button logic here
            // console.log(start.format('HH:mm'));

            @this.set('time', start.format('HH:mm'));


        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });

        $('input[id="seminar_date"]').daterangepicker({
                autoApply: true,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                },
            },
            function(start, end, label) {
                @this.set('date', start.format('YYYY-MM-DD'));
            });

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
        $(".webinar-item").each(function(index, element) {
            var totalSeconds = $(this).data('diff_in_seconds');
            // var days = $(this).find('.counter-outer[data-label = "days"]').data('value')
            // var hour = $(this).find('.counter-outer[data-label = "hours"]').data('value')
            // var minute = $(this).find('.counter-outer[data-label = "minutes"]').data('value')
            // var sec = $(this).find('.counter-outer[data-label = "seconds"]').data('value')

            // var totalSeconds = parseInt(days * 24 * 60 * 60) + parseInt(hour * 60 * 60) + parseInt(minute * 60) + sec;

            const countdownInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    // Countdown has reached zero
                    clearInterval(countdownInterval);
                    var startdate = $(this).attr("data-conteststartDate");
                    var conteststatus = $(this).attr("data-contest-status");

                    $(this).find('.time-contest').html(startdate);
                    $(this).find('.contest-name').html(conteststatus);
                    $(this).find('.register-btn').addClass('disabled');
                    $(this).find('.register-btn').removeAttr('data-bs-toggle');
                    $(this).find('.register-btn').removeAttr('data-bs-target');

                    // $(this).find('.time-contest').html('<div class="time-contest-inner"><p class="body-font-small text-white">Registrtion Closed</p><h4 class="text-white mb-0">' + startdate + '</h4></div>');
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