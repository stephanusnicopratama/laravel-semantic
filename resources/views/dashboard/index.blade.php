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
                url: '{{url('/')}}'
            });

            var myChart = Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Fruit Consumption'
                },
                xAxis: {
                    categories: ['Apples', 'Bananas', 'Oranges']
                },
                yAxis: {
                    title: {
                        text: 'Fruit eaten'
                    }
                },
                series: [{
                    name: 'Jane',
                    data: [1, 0, 4]
                }, {
                    name: 'John',
                    data: [5, 7, 3]
                }]
            });
        });
    </script>
@endsection
