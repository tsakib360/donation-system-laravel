<html>
<head>
	<meta charset="utf-8">
	<title>Donation System</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<h3 class="text-center" style="margin-top: 30px;">Donation with Stripe</h3>
            <div class="panel panel-default" style="margin-top: 60px;">

                <div class="panel-heading"><b>Donation</b></div>
                <div class="panel-body">



                    @if (Session::has('success'))

                        <div class="alert alert-success text-center">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                            <p>{{ Session::get('success') }}</p>

                        </div>

                    @endif



                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false"  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

                        @csrf


                        <input type="hidden" name="amount" value="{{$amount}}">
                        <input type="hidden" name="invoice" value="{{ uniqid()}}">
                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Donator Name</label>
                                <input class='form-control' size='4' type='text' name="cus_name" value="Tanvir Sakib">

                            </div>

                        </div>
                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Name on Card</label>
                                <input class='form-control' size='4' type='text' value="Test">

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-xs-12 form-group card required'>

                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='text' value="4242 4242 4242 4242">

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' value="123">
                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' value="12">

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' value="2024">

                            </div>

                        </div>



                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Donate Now ({{$amount}}$)</button>

                            </div>

                        </div>



                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    $(function() {

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {

    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),

        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');

    $inputs.each(function(i, el) {

    var $input = $(el);
    if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
    }
    });

    if (!$form.data('cc-on-file')) {
    e.preventDefault();
    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
    Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
    }, stripeResponseHandler);

    }

    });



    function stripeResponseHandler(status, response) {

        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {

            // token contains id, last4, and card type
            var token = response['id'];

            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

    });
</script>
</body>
</html>
