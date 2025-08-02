<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>
<body>
<div class="container">
    <div id="PrintTableArea">
    <h2>Payment Successfull</h1>
    <p>Dear {{$invoice->name}},</p>
    <p>Your Booking Details</p>
    <h4 style="color:green;">Payment Method:{{$invoice->payment_method}}</h4>
    <h4 style="color:green;">Transaction ID:{{$invoice->transcation_id}}</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Bus Name</th>
        <th scope="col">Sart NAme</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">Amount</th>

    </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$invoice->userRelation->name}}</td>
                <td>{{$invoice->userRelation->email}}</td>
                <td>{{$invoice->userRelation->phone}}</td>
                <td>{{$invoice->seat->bus->bus_name ?? null}}</td>
                <td>{{$invoice->seat->name ?? null}}</td>
                <td>{{$invoice->date}}</td>
                <td>{{$invoice->time}}</td>
                <td>{{$invoice->amount}}tk</td>
            </tr>
        </tbody>
    </table>
    <p>Thank you for receive our service.</p>
</body>
{{-- <center>  <a href="#" class="btn btn-warning" onclick="printDiv('PrintTableArea')">Print</a></center> --}}
</div>
</div>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
</html>
