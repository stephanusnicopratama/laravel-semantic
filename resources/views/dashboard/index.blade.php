@extends('layouts/index')

@section('content')
    <div class="ui vertically divided grid">
        <div class="two column row">
            <div class="column">
                <div id="container" style="width:100%; height:400px;"></div>
            </div>
            <div class="column">
                <div id="container2" style="width:100%; height:400px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '{{url('/manageItem/getAllData')}}',
                success: function (res) {
                    stockChart(res);
                }
            });

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '{{url('/transactionRecordSales/getTotalTransactionCurrentMonth')}}',
                success: function (res) {
                    totalSalesChart(res);
                }
            });
        });

        function stockChart(data) {
            var array_chart = [];
            $.each(data.data, function (k, v) {
                array_chart.push({name: v.item_name, y: v.item_stock});
            });
            var myChart = Highcharts.chart({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    renderTo: 'container'
                },
                title: {
                    text: 'Current Stock Qty'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {y}',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Total',
                    colorByPoint: true,
                    data: array_chart
                }]
            });
        }

        function totalSalesChart(data) {
            var array_chart = [];
            var currentMonth;
            $.each(data, function (k, v){
                currentMonth = moment(v.date).format('MMMM');
                array_chart.push({name: v.item_name, data:[parseInt(v.Total)]})
            });
            console.log(array_chart);
            Highcharts.chart({
                chart: {
                    type: 'column',
                    renderTo: 'container2'
                },
                title: {
                    text: 'Monthly Sales Item'
                },
                xAxis: {
                    categories: [
                        currentMonth
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Stock'
                    }
                },
                series: array_chart
            });
        }
    </script>
@endsection
