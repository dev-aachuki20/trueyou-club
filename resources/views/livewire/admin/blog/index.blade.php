<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)

                        @include('livewire.admin.blog.form')

                    @elseif($viewMode)

                        @livewire('admin.blog.show', ['blog_id' => $blog_id])

                    @else
                        <div wire:loading wire:target="create" class="loader"></div>
                        <div class="card-title top-box-set">
                            <h4 class="card-title-heading">@lang('cruds.blog.title') @lang('global.list') </h4>
                            <div class="card-top-box-item">
                                @can('blog_create')
                                <button wire:click="create()" type="button" class="btn btn-sm btn-success btn-icon-text btn-header">
                                    <i class="ti-plus btn-icon-prepend"></i>                                                    
                                        {{__('global.add')}}
                                </button>
                                @endcan
                            </div>
                        </div> 
                        <div class="table-responsive search-table-data">
                           
                            @livewire('admin.blog.blog-table')                       
                            
                        </div>
                        
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/assets/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script type="text/javascript">

    document.addEventListener('loadPlugins', function (event) {

        $('input[id="publish_date"]').daterangepicker({
            autoApply: true,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
        },
        function(start, end, label) {
            @this.set('publish_date', start.format('YYYY-MM-DD'));
        });

        $('.dropify').dropify();
        $('.dropify-errors-container').remove();
        $('.dropify-clear').click(function(e) {
            e.preventDefault();
            var elementName = $(this).siblings('input[type=file]').attr('id');
            if(elementName == 'dropify-image'){
               @this.set('image',null);
               @this.set('originalImage',null);
               @this.set('removeImage',true);
            }
        });

        $('textarea#summernote').summernote({
            placeholder: 'Type somthing...',
            tabsize: 2,
            height: 200,
            fontNames: ['Arial', 'Helvetica', 'Times New Roman', 'Courier New','sans-serif'],
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', [/*'link', 'picture', 'video'*/]],
                ['view', ['codeview', /*'help'*/]],
            ],
            callbacks: {
                onChange: function(content) {
                    // Update the Livewire property when the Summernote content changes
                    @this.set('content', content);
                }
            }
        });

    });

</script>
@endpush
