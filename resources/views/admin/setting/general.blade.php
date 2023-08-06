<div class="tile">
    <form action="{{ route('admin.setting.update') }}" method="POST" role="form">
        @csrf
        <hr>
        <h3>{{__('labels.fields.general_settings')}}</h3>
        <hr>

        <div class="">
{{--            <div class="form-group">--}}
{{--                <label for="currency_code"> {{__('labels.fields.currency_code')}}<span class="text-danger">*</span></label>--}}
{{--                <input type="text"--}}
{{--                        class="form-control @error('currency_code') is-invalid @enderror"--}}
{{--                        id="currency_code"--}}
{{--                        name="currency_code"--}}
{{--                        placeholder="{{__('labels.fields.currency_code')}}"--}}
{{--                        value="{{old('currency_code',config('settings.currency_code'))}}"--}}
{{--                        required/>--}}
{{--                    @error('currency_code')--}}
{{--                    <div class="invalid-feedback">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label for="site_tax"> {{__('labels.fields.site_tax')}} ( % )<span class="text-danger">*</span></label>--}}
{{--                <input type="number"--}}
{{--                        class="form-control @error('site_tax') is-invalid @enderror"--}}
{{--                        id="site_tax"--}}
{{--                        name="site_tax"--}}
{{--                        placeholder="{{__('labels.fields.site_tax')}}"--}}
{{--                        value="{{old('site_tax',config('settings.site_tax'))}}"--}}
{{--                        required/>--}}
{{--                    @error('site_tax')--}}
{{--                    <div class="invalid-feedback">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label for="min_order_amount"> {{__('labels.fields.min_order_amount')}} ( {{ config('settings.currency_code') }} )<span class="text-danger">*</span></label>--}}
{{--                <input type="number"--}}
{{--                        class="form-control @error('min_order_amount') is-invalid @enderror"--}}
{{--                        id="min_order_amount"--}}
{{--                        name="min_order_amount"--}}
{{--                        placeholder="{{__('labels.fields.min_order_amount')}}"--}}
{{--                        value="{{old('min_order_amount',config('settings.min_order_amount'))}}"--}}
{{--                        required/>--}}
{{--                    @error('min_order_amount')--}}
{{--                    <div class="invalid-feedback">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--            </div>--}}

            <div class="form-group">
                <label for="image_size"> {{__('labels.fields.image_size')}} ( MB )<span class="text-danger">*</span></label>
                <input type="number"
                        class="form-control @error('image_size') is-invalid @enderror"
                        id="image_size"
                        name="image_size"
                        placeholder="{{__('labels.fields.image_size')}}"
                        value="{{old('image_size',config('settings.image_size')/1024)}}"
                        required/>
                    @error('image_size')
                    <div class="invalid-feedback">{{$message}}</div>
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
