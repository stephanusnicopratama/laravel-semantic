@extends('layouts/index')

@section('content')
    <h3>Filter</h3>
    <form id="formRange">
        <div class="ui form">
            <div class="two fields">
                <div class="field">
                    <label>Start date</label>
                    <div class="ui calendar" id="rangestart">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Start" name="rangestart" readonly>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>End date</label>
                    <div class="ui calendar" id="rangeend">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="End" name="rangeend" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <button type="button" class="ui right floated blue button">Search</button>
                <button type="button" class="ui left floated blue button">View All</button>
            </div>
        </div>
    </form>
    <br/>
    <h3 class="ui top attached header">
        <i class="table icon"></i>
        Master Transaction
    </h3>
    <div class="ui attached segment">
        <table class="ui celled table" cellspacing="0" width="100%" id="tblMaster"></table>
    </div>

    <div class="ui modal" id="modalDetail">
        <div class="header">Header</div>
        <div class="scrolling content">
            <table class="ui celled table" cellspacing="0" width="100%" id="tblDetail"></table>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $("#tblMaster").DataTable({
            processing: true,
            destroy: true,
            ajax: {
                type: 'GET',
                url: '{{url('/transactionRecordSales/getMasterTransaction')}}',
                dataType: 'JSON',
            },
            columns: [
                {
                    title: 'Action', data: 'transaction_code', render: function (data) {
                    return '<button class="ui blue basic button"  id="' + data + '">Detail</button>';
                }
                },
                {title: 'Transaction Code', data: 'transaction_code'},
                {title: 'Total', data: 'total'},
                {
                    title: 'Date', data: 'date', render: function (data) {
                    return moment(data).format('DD MMMM YYYY, HH:MM');
                }
                },
                {title: 'User', data: 'user'},
            ]
        });

        $('#rangestart').calendar({
            type: 'date',
            endCalendar: $('#rangeend')
        });
        $('#rangeend').calendar({
            type: 'date',
            startCalendar: $('#rangestart')
        });

        $('button.ui.left.floated.blue.button').click(function () {
            $("#tblMaster").DataTable({
                processing: true,
                destroy: true,
                ajax: {
                    type: 'GET',
                    url: '{{url('/transactionRecordSales/getMasterTransaction')}}',
                    dataType: 'JSON',
                },
                columns: [
                    {
                        title: 'Action', data: 'transaction_code', render: function (data) {
                        return '<button class="ui blue basic button"  id="' + data + '">Detail</button>';
                    }
                    },
                    {title: 'Transaction Code', data: 'transaction_code'},
                    {title: 'Total', data: 'total'},
                    {
                        title: 'Date', data: 'date', render: function (data) {
                        return moment(data).format('DD MMMM YYYY, HH:MM');
                    }
                    },
                    {title: 'User', data: 'user'},
                ]
            });
        });

        $('button.ui.right.floated.blue.button').click(function () {
            $("#tblMaster").DataTable({
                processing: true,
                destroy: true,
                ajax: {
                    type: 'GET',
                    data: {
                        rangestart: $('input[name = rangestart]').val(),
                        rangeend: $('input[name = rangeend]').val()
                    },
                    url: '{{url('/transactionRecordSales/getRangeMasterTransaction')}}',
                    dataType: 'JSON',
                },
                columns: [
                    {
                        title: 'Action', data: 'transaction_code', render: function (data) {
                        return '<button class="ui blue basic button" id="' + data + '" >Detail</button>';
                    }
                    },
                    {title: 'Transaction Code', data: 'transaction_code'},
                    {title: 'Total', data: 'total'},
                    {
                        title: 'Date', data: 'date', render: function (data) {
                        return moment(data).format('DD MMMM YYYY, HH:MM');
                    }
                    },
                    {title: 'User', data: 'user'},
                ]
            });
        });

        $('#tblMaster tbody').on('click', 'button', function () {
            var code = $(this).attr('id');
            $('#tblDetail').DataTable({
                destroy: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: '{{url('/transactionRecordSales/getListDetailTransaction')}}',
                    data: {code: code},
                    dataType: 'JSON',
                },
                columns: [
                    {title: 'Transaction Code', data: 'transaction_code'},
                    {title: 'Item Code', data: 'item_code'},
                    {title: 'Price', data: 'price'},
                    {title: 'Quantity', data: 'qty'},
                ]
            });
            $('#modalDetail').modal('show')
        });


    </script>
@endsection