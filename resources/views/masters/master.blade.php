<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral System</title>
    
    <link rel="stylesheet" href="{{ asset('assets\css\style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\css\bootstrap.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('DataTables-1.10.23\css\jquery.dataTables.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script type="text/javascript" src="{{ asset('assets\js\jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>
</head>
<body>
    <div>
        @yield('content')
    </div>
    
    <script type="text/javascript" src="{{ asset('assets\js\bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets\js\main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('DataTables-1.10.23\js\jquery.dataTables.js') }}"></script>
</body>
</html>