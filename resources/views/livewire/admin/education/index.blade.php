<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)

                    @include('livewire.admin.education.form')

                    @elseif($viewMode)

                    @livewire('admin.education.show', ['education_id' => $education_id])

                    @else
                    <div wire:loading wire:target="create" class="loader"></div>
                    <div class="card-title top-box-set">
                        <h4 class="card-title-heading">@lang('cruds.education.title') @lang('global.list') </h4>
                        <div class="card-top-box-item">
                            @can('education_create')
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

                       <div class="relative">

                            @include('admin.partials.table-show-entries-search-box',['searchBoxPlaceholder'=>$searchBoxPlaceholder])
                            
                            <div class="webinar_listing">
                                <div class="row">
                                @if($allEducation->count() > 0)
                                @foreach($allEducation as $serialNo => $education)
                                <div class="col-12 col-md-6">
                                    <div class="webinar-item">
                                        <div class="webinar-item-inner">
                                            <div class="webinar-img">
                                                <img class="img-fluid" src="{{ $education->featured_image_url ? $education->featured_image_url : asset(config('constants.default.no_image')) }}" alt="">
                                            </div>
                                            <div class="webinar-content">
                                                <h3>
                                                    {{ ucwords($education->title) }}
                                                </h3>
                                                <div class="limit-description">
                                                    {!! $education->category->name !!}
                                                </div>
                                                <div class="limit-description">
                                                    {!! $education->description !!}
                                                </div>

                                                <span class="quotes-date seminar-date">
                                                    <x-svg-icon icon="small-calender" />
                                                    {{ convertDateTimeFormat($education->created_at,'fulldate') }}
                                                </span>


                                            </div>
                                        </div>
                                        <div class="update-webinar">
                                            <ul class="d-flex">
                                                @can('education_edit')
                                                <li>
                                                    <a href="javascript:void()" wire:click.prevent="$emitUp('edit', {{$education->id}})" title="Edit">
                                                        <x-svg-icon icon="edit" />
                                                    </a>
                                                </li>
                                                @endcan

                                                @can('education_delete')
                                                <li>
                                                    <a href="javascript:void()" wire:click.prevent="$emitUp('delete', {{$education->id}})" title="Delete">
                                                        <x-svg-icon icon="delete" />
                                                    </a>
                                                </li>
                                                @endcan

                                                @can('education_show')
                                                <li>
                                                    <a href="javascript:void()" wire:click.prevent="$emitUp('show', {{$education->id}})" title="View">
                                                        <x-svg-icon icon="view" />
                                                    </a>
                                                </li>
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
                                {{ $allEducation->links('vendor.pagination.custom-pagination') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<!-- Video Preview Modal -->
<div id="video-preview-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-50 modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Video Preview</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <video id="video-preview" width="100%" controls>
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/assets/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        // Initialize Dropify when the page is loaded
        initializeDropify();

        // Handle the change event for video_type dropdown
        $('#video_type_select').on('change', function () {
            toggleVideoInputs($(this).val());
        });

        // Reinitialize Dropify when Livewire processes an update
        Livewire.hook('message.processed', function () {
            initializeDropify();
            toggleVideoInputs($('#video_type_select').val());
        });
    });

    function toggleVideoInputs(videoType) {
        const videoLinkInput = $('#video_link_input');
        const videoUploadInput = $('#video_upload_input');

        if (videoType === 'video_link') {
            videoLinkInput.show();
            videoUploadInput.hide();
        } else if (videoType === 'upload_video') {
            videoLinkInput.hide();
            videoUploadInput.show();
        } else {
            videoLinkInput.hide();
            videoUploadInput.hide();
        }
    }  

    function initializeDropify(){
        $('.dropify').dropify();
        // Show preview button if video is uploaded
        $('.dropify').on('change', function () {
            if (this.files && this.files[0]) {
                $('#preview-video-btn').show();
            }
        });

        // Preview Button Click Event      
        $('#preview-video-btn').on('click', function (e) {
            e.preventDefault();
            const fileInput = document.getElementById('dropify-video');
            const file = fileInput.files[0];
            const defaultFile = $(fileInput).data('default-file');

            if (file) {
                const fileURL = URL.createObjectURL(file);
                $('#video-preview').attr('src', fileURL);
                $('#video-preview-modal').modal('show');
            } else if (defaultFile) {
                // Use the default file URL for preview if in update mode
                $('#video-preview').attr('src', defaultFile);
                $('#video-preview-modal').modal('show');
            }
        });        
        // Handle modal close event
        $('#video-preview-modal').on('hidden.bs.modal', function () {
            $('#video-preview').attr('src', ''); // Clear video source when modal is closed
        });
        
        $('.dropify-errors-container').remove();
        $('.dropify-clear').click(function(e) {
            e.preventDefault();
            var elementName = $(this).siblings('input[type=file]').attr('id');
            if (elementName == 'dropify-image') {
                @this.set('image', null);
                @this.set('originalImage', null);
                @this.set('removeImage', true);
            }

            if (elementName == 'dropify-video') {
                @this.set('video', null);
                @this.set('originalVideo', null);
                @this.set('removeVideo', true); 
                Livewire.emit('clearVideo');  
                $('#preview-video-btn').hide();             
            }           
        });
    }

    document.addEventListener('loadPlugins', function(event)
    {
        initializeDropify();
        $('textarea#summernote').summernote({
            placeholder: 'Type something...',
            tabsize: 2,
            height: 200,
            fontNames: ['Arial', 'Helvetica', 'Times New Roman', 'Courier New', 'sans-serif'],
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', [ /*'link', 'picture', 'video'*/ ]],
                ['view', ['codeview', /*'help'*/ ]],
            ],
            callbacks: {
                onChange: function(description) {
                    // Update the Livewire property when the Summernote description changes
                    @this.set('description', description);
                }
            }
        });

        $('#updateButton').on('click', function() {
            // Get the current code view content
            var codeViewDescription = $('textarea#summernote').summernote('code');

            // Set the description in the code view
            $('textarea#summernote').summernote('code', codeViewDescription);

            // Trigger the Livewire update
            @this.set('description', codeViewDescription);
        });

    });

    
</script>
@endpush