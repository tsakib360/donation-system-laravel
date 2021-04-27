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
        	<h3 class="text-center" style="margin-top: 30px;"><a href="/">Home</a> | Donation List</h3>
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invoice</th>
                    <th scope="col">Donator</th>
                    <th scope="col">Amount (In Dollar)</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment Type</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($donation_list as $key => $dl)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$dl->invoice_id}}</td>
                            <td>{{$dl->cus_name}}</td>
                            <td>{{$dl->amount}}</td>
                            <td>{{$dl->created_at->format("F j, Y, g:i a")}}</td>
                            @if ($dl->payment_type == 'Paypal')
                                <td><button class="btn btn-primary">{{$dl->payment_type}}</button></td>
                            @elseif($dl->payment_type == 'Stripe')
                                <td><button class="btn btn-info">{{$dl->payment_type}}</button></td>
                            @endif
                            
                        </tr>
                    @endforeach
                  
                </tbody>
              </table>
        </div>
    </div>
</div>
</body>
</html>
