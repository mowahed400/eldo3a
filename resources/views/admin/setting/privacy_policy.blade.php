@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.css')}}">
@endpush

<div class="tile">
    <form action="{{ route('admin.setting.update') }}" method="POST" role="form">
        @csrf
        <h3 class="">{{__('labels.fields.privacy_policy')}}</h3>
        <hr>
        <div class="">
            <div class="form-group">
                <textarea name="privacy_policy" id="privacy_policy"
                          cols="30"
                          rows="10"
                          class="form-control @error('privacy_policy') is-invalid @enderror"
                >{{old('privacy_policy', settings('privacy_policy'))}}</textarea>
                @error('privacy_policy')
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

        $('#privacy_policy').summernote({
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
