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
        	<h3 class="text-center" style="margin-top: 30px;">Donation</h3>
            <div class="panel panel-default" style="margin-top: 60px;">

                <div class="panel-heading"><b>Home | <a href="{{route('donation.list')}}">Donation List</a></b></div>
                <div class="panel-body">

                    @if ($message = Session::get('success'))
                    <div class="custom-alerts alert alert-success fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {!! $message !!}
                    </div>
                    <?php Session::forget('success');?>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="custom-alerts alert alert-danger fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {!! $message !!}
                    </div>
                    <?php Session::forget('error');?>
                    @endif
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Enter Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-primary" onclick="payWithPaypal()">
                                    Donate with Paypal
                                </button>
                            </div>
                            <div class="col-md-6 col-md-offset-4" style="margin-top: 10px;">
                                Or
                            </div>
                            <div class="col-md-6 col-md-offset-4" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-info" onclick="payWithStripe()">
                                    Donate with Stripe
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function payWithPaypal()
    {
        var amount = document.getElementById('amount').value;
        window.location = '/donate/paypal?amount=' + amount;
    }

    function payWithStripe()
    {
        var amount = document.getElementById('amount').value;
        window.location = '/donate/stripe?amount=' + amount;
    }
</script>
</body>
</html>
