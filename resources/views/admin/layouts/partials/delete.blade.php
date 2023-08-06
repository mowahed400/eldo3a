@push('js')
<script>
    const {{ $method_name ?? 'deleteItem' }} = id => {
        Swal.fire({
            title: '{{__('messages.static.delete_confirm_title')}}',
            text: "{{__('messages.static.delete_confirm_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{__('messages.static.delete_btn_yes')}}',
            cancelButtonText: '{{__('messages.static.delete_btn_cancel')}}'
        }).then((result) => {
            if (result.value) {
                let f = document.createElement("form");
                f.setAttribute('method',"post");
                f.setAttribute('action',`{{ $route }}${id}`);

                let i1 = document.createElement("input"); //input element, text
                i1.setAttribute('type',"hidden");
                i1.setAttribute('name','_token');
                i1.setAttribute('value','{{csrf_token()}}');

                let i2 = document.createElement("input"); //input element, text
                i2.setAttribute('type',"hidden");
                i2.setAttribute('name','_method');
                i2.setAttribute('value','DELETE');

                f.appendChild(i1);
                f.appendChild(i2);
                document.body.appendChild(f);
                f.submit()
            }
        });
    }
</script>

@endpush