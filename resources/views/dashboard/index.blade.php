@extends('layouts/index')

@section('content')
    <div id="container" style="width:100%; height:400px;"></div>
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
        });

        function stockChart(data) {
            var array_chart = [];
            $.each(data.data, function (k, v) {
                array_chart.push({name: v.item_name, y: v.item_stock});
            });
            var myChart = Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
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
    </script>
@endsection
