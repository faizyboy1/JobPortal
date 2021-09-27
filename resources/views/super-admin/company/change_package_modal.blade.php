<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">

<div class="modal-header">
    <h4 class="modal-title">@lang('app.change') @lang('app.package')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="editSettings" class="ajax-form">
                @csrf
                <div class="form-group">
                    <label for="company_name">@lang('app.package')</label>
                    <select name="package" id="package_id" class="form-control">
                        <option value="">--</option>
                        @foreach ($packages as $item)
                            <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    @lang('app.monthlyPackages')  
                    <input id="package-switch" type="checkbox" class="js-switch" name="package_type" /> 
                    @lang('app.yearlyPackages') 
                </div>
                    
            </form>
        </div>

    </div>

    @foreach ($packages as $item)
        <div class="row monthly-{{ $item->id }} mt-3 package-details" style="display:none;">
            <div class="col-md-4">
                <strong>@lang('app.price')</strong><br> {{ $global->currency->currency_symbol.$item->monthly_price }}
            </div>
            <div class="col-md-4">
                <strong>@lang('app.startDate')</strong><br> {{ \Carbon\Carbon::today()->format('d M, Y') }}
            </div>
            <div class="col-md-4">
                <strong>@lang('app.endDate')</strong><br> {{ \Carbon\Carbon::today()->addMonth()->format('d M, Y') }}
            </div>
        </div>
        <div class="row yearly-{{ $item->id }} mt-3 package-details" style="display:none;">
            <div class="col-md-4">
                <strong>@lang('app.price')</strong><br> {{ $global->currency->currency_symbol.$item->annual_price }}
            </div>
            <div class="col-md-4">
                <strong>@lang('app.startDate')</strong><br> {{ \Carbon\Carbon::today()->format('d M, Y') }}
            </div>
            <div class="col-md-4">
                <strong>@lang('app.endDate')</strong><br> {{ \Carbon\Carbon::today()->addYear()->format('d M, Y') }}
            </div>
        </div>
    @endforeach

</div>
<div class="modal-footer">
        <button type="button" id="save-package" class="btn btn-success">@lang('app.save')</button>
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">@lang('app.close')</button>
</div>

<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
    var switchery = new Switchery(html, { size: 'medium' });
    });

    $('#package_id, #package-switch').change(function() {
        let type = $('#package-switch').is(":checked");
        let packageId = $('#package_id').val();

        if(packageId != "") {
            if(type) {
                $('.package-details').hide();
                $('.yearly-'+packageId).show();
            }
            else {
                $('.package-details').hide();
                $('.monthly-'+packageId).show();
            }
        }
        else {
            $('.package-details').hide();
        }
    })

    $('#save-package').click(function(){
        let url = "{{ route('superadmin.company.updateCompanyPackage', [$company->id]) }}";
        $.easyAjax({
            type: 'POST',
            url: url,
            data: $('#editSettings').serialize(),
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
                    window.location.reload();
                }
            }
        });
    })
    
</script>