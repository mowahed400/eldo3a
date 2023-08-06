@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.css')}}">
@endpush

<div class="tile">
    <form action="{{ route('admin.setting.update') }}" method="POST" role="form">
        @csrf
        <h3 class="">{{__('labels.fields.help')}}</h3>
        <hr>
        <div class="">
            <div class="form-group">
                <textarea name="help" id="help"
                          cols="30"
                          rows="10"
                          class="form-control @error('help') is-invalid @enderror"
                >{{old('help', settings('help'))}}</textarea>
                @error('help')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{__('messages.static.save')}}</button>
                </div>
            </div>
        </div>
    </form>

</div>

@push('js')
    <!-- Summernote -->
    <script src="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>

    <!-- Page specific script -->
    <script>

        // Summernote

        $('#help').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['forecolor']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['table', ['table']],
                // ['insert', ['link']],
                ['view', ['codeview']],
            ]
        })


    </script>
@endpush
