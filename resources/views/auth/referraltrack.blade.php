@extends('masters.master')
@section('content')
<div class="wrapper d-flex align-items-stretch">
    @include('auth.layout')
    <div id="content" class="p-4 p-md-5 pt-5">
        <div>
            <h4 class="mb-4" style="float: left;">Referral Track</h4><br>
            <hr style="border: 1px solid lightgray;">
        </div>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript">
    var datelabels = JSON.parse(@json($datelabels));
    var datedata = JSON.parse(@json($datedata));
    var canvas = document.getElementById('myChart');
    var data = {
    // labels: ["January", "February", "March", "April", "May", "June", "July"],
        labels: datelabels,
        datasets: [
            {
                label: "Referral User",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                // data: [65, 59, 80, 0, 56, 55, 40],
                data: datedata,
            }
        ]
    };

    var option = {
    showLines: true
    };
    var myLineChart = Chart.Line(canvas,{
    data:data,
    options:option
    });
</script>
<style>
    #myChart{
        width: 100% !important;
    }
</style>
@endsection