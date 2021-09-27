<style>
    .stripe-button-el {
        display: none;
    }

    .displayNone {
        display: none;
    }

    .checkbox-inline,
    .radio-inline {
        vertical-align: top !important;
    }

    .payment-type {
        border: 1px solid #e1e1e1;
        padding: 20px;
        background-color: #f3f3f3;
        border-radius: 10px;

    }

    .box-height {
        height: 78px;
    }

    .button-center {
        display: flex;
        justify-content: center;
    }

    .paymentMethods {
        display: none;
        transition: 0.3s;
    }

    .paymentMethods.show {
        display: block;
    }

    .stripePaymentForm {
        display: none;
        transition: 0.3s;
    }

    .stripePaymentForm.show {
        display: block;
    }

    .authorizePaymentForm {
        display: none;
        transition: 0.3s;
    }

    .authorizePaymentForm.show {
        display: block;
    }

    div#card-element {
        width: 100%;
        color: #4a5568;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        line-height: 1.25;
        border-width: 1px;
        border-radius: 0.25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-style: solid;
        border-color: #e2e8f0;
    }

    .paystack-form {
        display: inline-block;
        position: relative;
    }

    .payment-type {
        margin: 0 5px;
        width: 100%;
    }

    .payment-type button {
        margin: 5px 5px;
        float: none;
    }

    .d-webkit-inline-box {
        display: inline;
    }

    .m-l-10 {
        margin-left: 10px;
    }
</style>
<div id="event-detail">
    <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-cash"></i> Choose Payment Method</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

    </div>
    <div class="modal-body">
        <div class="form-body button-center">
            <div class="row paymentMethods show">
                <div class="col-12 col-sm-12 mt-40 text-center">
                    <div class="d-flex justify-content-center flex-wrap">
                        @if($stripeSettings->paypal_client_id != null && $stripeSettings->paypal_secret != null &&
                        $stripeSettings->paypal_status == 'active')
                        <button type="submit"
                            class="btn btn-warning waves-effect mx-2 waves-light paypalPayment pull-left"
                            data-toggle="tooltip" data-placement="top" title="Choose Plan">
                            <i class="icon-anchor display-small"></i><span>
                                <i class="fa fa-paypal"></i> @lang('app.payPaypal')</span>
                        </button>
                        @endif
                        @if($stripeSettings->razorpay_key != null && $stripeSettings->razorpay_secret != null &&
                        $stripeSettings->razorpay_status == 'active')
                        <button type="submit" class="btn btn-info waves-effect mx-2 waves-light pull-left m-l-10"
                            onclick="razorpaySubscription();" data-toggle="tooltip" data-placement="top"
                            title="Choose Plan">
                            <i class="icon-anchor display-small"></i><span>
                                <i class="fa fa-credit-card-alt"></i> RazorPay </span>
                        </button>
                        @endif
                        @if($stripeSettings->api_key != null && $stripeSettings->api_secret != null &&
                        $stripeSettings->stripe_status == 'active')
                        <button type="submit" class="btn btn-success mx-2 waves-effect waves-light stripePay"
                            data-toggle="tooltip" data-placement="top" title="Choose Plan">
                            <i class="icon-anchor display-small"></i><span>
                                <i class="fa fa-cc-stripe"></i> @lang('app.payStripe')</span></button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row stripePaymentForm">
                @if($stripeSettings->api_key != null && $stripeSettings->api_secret != null &&
                $stripeSettings->stripe_status == 'active')
                <div class="m-l-10">
                    <form id="stripe-form" action="{{ route('admin.payments.stripe') }}" method="POST">
                        <input type="hidden" id="name" name="name" value="{{ $user->name }}">
                        <input type="hidden" id="stripeEmail" name="stripeEmail" value="{{ $user->email }}">
                        <input type="hidden" name="plan_id" value="{{ $package->id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        {{ csrf_field() }}
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('modules.stripeCustomerAddress.name')</label>
                                    <input type="text" required name="clientName" id="clientName" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('modules.stripeCustomerAddress.line1')</label>
                                    <input type="text" required name="line1" id="line1" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.stripeCustomerAddress.city')</label>
                                    <input type="text" required name="city" id="city" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.stripeCustomerAddress.state')</label>
                                    <input type="text" required name="state" id="state" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.stripeCustomerAddress.country')</label>
                                    <input type="text" required name="country" id="country" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <small>* Address country must be a valid <a
                                        href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2"
                                        target="_blank">2-alphabet ISO-3166 code</a></small>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <label for="card-element" class="block text-gray-700 text-sm font-bold mb-2">
                                Card Info
                            </label>
                            <div id="card-element"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div id="card-errors" class="text-red-400 text-bold mt-2 text-sm font-medium"></div>
                        </div>

                        <!-- Stripe Elements Placeholder -->
                        <div class="flex flex-wrap mt-6" style="margin-top: 15px; text-align: center">
                            <button type="submit" id="card-button"
                                class="btn btn-success inline-block align-middle text-center select-none border font-bold whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700">
                                <i class="fa fa-cc-stripe"></i> {{ __('Pay') }}
                            </button>
                        </div>
                    </form>

                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@if($stripeSettings->stripe_status == 'active')
<script>
    const stripe = Stripe('{{ config("cashier.key") }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        let validCard = false;
        const cardError = document.getElementById('card-errors');

        cardElement.addEventListener('change', function(event) {

            if (event.error) {
                validCard = false;
                cardError.textContent = event.error.message;
            } else {
                validCard = true;
                cardError.textContent = '';
            }
        });

        var form = document.getElementById('stripe-form');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
        var line1 = $('#line1').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var country = $('#country').val();

        $('#card-button').attr("disabled", true);

        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value,
                    address: {
                        line1: line1,
                        city: city,
                        state: state,
                        country: country,
                    }
                }
            }
        );

        if (error) {
            // Display "error.message" to the user...
            $('#card-button').attr("disabled", false);
        } else {
            // The card has been verified successfully...
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
        });

</script>
@endif
<script>
    $('.stripePay').click(function(e){
        e.preventDefault();
        $('.paymentMethods').removeClass('show');
        $('.stripePaymentForm').addClass('show');
        $('.modal-title').text('Enter Your Card Details');
    });

    // redirect on paypal payment page
    $('body').on('click', '.paypalPayment', function(){
        $.easyBlockUI('#package-select-form', 'Redirecting Please Wait...');
        var url = "{{ route('admin.paypal', [$package->id, $type]) }}";
        window.location.href = url;
    }); 
</script>
@if($stripeSettings->razorpay_status == 'active')
<script>
    //Confirmation after transaction
    function razorpaySubscription() {
        var plan_id = '{{ $package->id }}';
        var type = '{{ $type }}';
        $.easyAjax({
            type:'POST',
            url:'{{route('admin.subscribe.razorpay-subscription')}}',
            data: {plan_id: plan_id,type: type,_token:'{{csrf_token()}}'},
            success:function(response){
                razorpayPaymentCheckout(response.subscriprion)
            }
        })
    }

    //Razorpay payment checkout
    function razorpayPaymentCheckout(subscriptionID) {
        var options = {
            "key": "{{ $stripeSettings->razorpay_key }}",
            "subscription_id":subscriptionID,
            "name": "{{$companyName}}",
            "description": "{{ addslashes($package->description) }}",
            "image": "{{ $logo }}",
            "handler": function (response){
                confirmRazorpayPayment(response);
            },
            "notes": {
                "package_id": '{{ $package->id }}',
                "package_type": '{{ $type }}',
                "company_id": '{{ $company->id }}'
            },
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    }

    //Confirmation after transaction
    function confirmRazorpayPayment(response) {
        var plan_id = '{{ $package->id }}';
        var type = '{{ $type }}';
        var payment_id = response.razorpay_payment_id;
        var subscription_id = response.razorpay_subscription_id;
        var razorpay_signature = response.razorpay_signature;
        $.easyAjax({
            type:'POST',
            url:'{{route('admin.subscribe.razorpay-payment')}}',
            data: {paymentId: payment_id,plan_id: plan_id,subscription_id: subscription_id,type: type,razorpay_signature: razorpay_signature,_token:'{{csrf_token()}}'},
            redirect:true,
        })
    }

</script>
@endif