@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="write icon"></i>
        Sales Transaction
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formSales">
            {!! csrf_field() !!}

            <div class="field">
                <div class="field">
                    <label>Sales Code</label>
                    <input type="text" name="salesCode" id="salesCode" readonly>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Item Code</label>
                        <div class="ui search">
                            <input type="text" name="itemCode" id="itemCode" class="prompt">
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Item Name</label>
                        <input type="text" name="itemName" id="itemName" readonly>
                    </div>
                </div>
                <div class="three fields">
                    <div class="field">
                        <label>Price</label>
                        <input type="text" name="price" id="price" readonly>
                    </div>
                    <div class="field">
                        <label>Qty</label>
                        <input type="text" name="qty" id="qty">
                    </div>
                    <div class="field">
                        <label>Total</label>
                        <input type="text" name="total" id="total" value="0" readonly>
                    </div>
                </div>

                <button class="ui primary button" id="btnInsert" type="submit">Insert</button>
                <button class="ui button" id="btnCancel" type="button">Cancel</button>
            </div>
        </form>
    </div>

    <h3 class="ui top attached header">
        <i class="in cart icon"></i>
        Sales Cart
    </h3>
    <div class="ui attached segment" id="divTable">
        <table class="ui celled table" cellspacing="0" width="100%" id="tblSales">
            {{--<tfoot><tr><td colspan="4"></td><td></td><td></td><td></td></tr></tfoot>--}}
        </table>
        <button class="ui fluid blue button" id="btnNextTrans" type="button">Next Transaction</button>
    </div>
@endsection

@section('script')
    <script>
        autoNumber();

        var content = [];
        $.ajax({
            type: 'GET',
            url: '{{url('/transactionSales/getAllItem')}}',
            dataType: 'JSON',
            success: function (res) {
                $.each(res, function (k, v) {
                    content.push({'title': v.item_code});
                });
            }, complete: function () {
                $('.ui.search').search({
                    source: content,
                    onSelect: function (result) {
                        $.ajax({
                            type: 'GET',
                            data: {code: result.title},
                            url: '{{url('/transactionSales/getItem')}}',
                            dataType: 'JSON',
                            success: function (res) {
                                $('#itemName').val(res[0].item_name);
                                $('#price').val(res[0].selling_price);
                            }
                        });
                    }
                });
            }
        });

        $('#itemCode').on('change', function () {
            $.ajax({
                type: 'GET',
                data: {code: $('#itemCode').val()},
                url: '{{url('/transactionSales/getItem')}}',
                dataType: 'JSON',
                success: function (res) {
                    $('#itemName').val(res[0].item_name);
                    $('#price').val(res[0].selling_price);
                    if (res[0].selling_price === '') {
                        $('#total').val('0');
                    }
                    if ($('#qty').val() != '') {
                        var total = $('#qty').val() * $('#price').val();
                        $('#total').val(total);
                    }
                }
            });
        });

        $('#qty').keyup(function () {
            var total = $('#qty').val() * $('#price').val();
            $('#total').val(total);
        });

        $('#formSales').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                data: $('#formSales').serializeArray(),
                dataType: 'JSON',
                url: '{{url('/transactionSales/insertCart')}}',
                success: function (res) {
                    console.log(res);
                    table.ajax.reload();
                }, error: function (err) {
                    alert(err);
                }
            });
        });

        var table = $('#tblSales').DataTable({
            responsive: true,
            processing: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                type: 'GET',
                url: '{{url('/transactionSales/getCart')}}',
                dataType: 'JSON',
            },
            columns: [
                {
                    title: 'Action', data: 'id', render: function (data) {
                    return '<div class="ui buttons">' +
                        '<button class="ui positive button" id="' + data + '">Edit</button>' +
                        '<div class="or"></div>' +
                        '<button class="ui negative button" id="' + data + '">Delete</button>' +
                        '</div>';
                }
                },
                {title: 'Transaction Code', data: 'transaction_code'},
                {title: 'Item Code', data: 'item_code'},
                {title: 'Item Name', data: 'item_name'},
                {title: 'Qty', data: 'qty'},
                {title: 'Price', data: 'price'},
                {
                    title: 'Total', render: function (data, type, full, meta) {
                    return full.qty * full.price;
                }
                },
            ],
        });

        $('#tblSales tbody').on('click', 'button.ui.positive.button', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                data: {_token: $('[name="_token"]').val(), id: id},
                url: '{{url('/transactionSales/getEditCart')}}',
                dataType: 'JSON',
                success: function (res) {
                    console.log(res);
                }
            });
        });
        $('#tblSales tbody').on('click', 'button.ui.negative.button', function () {
            if (confirm('Are you sure?')) {
                var id = $(this).attr('id');
                $.ajax({
                    type: 'DELETE',
                    data: {_token: $('[name="_token"]').val(), id: id},
                    url: '{{url('/transactionSales/deleteCart')}}',
                    dataType: 'JSON',
                    success: function (res) {
                        console.log(res);
                        table.ajax.reload();
                    }
                });
            }
        });

        $('#btnNextTrans').click(function () {
            if (confirm('Are you sure?')) {
                $.ajax({
                    type: 'GET',
                    url: '{{url('/transactionSales/insertTransaction')}}',
                    dataType: 'JSON',
                    success: function (res) {
                        console.log(res);
                        $('#formSales')[0].reset();
                        autoNumber();
                        table.ajax.reload();
                    }
                });
            }
        });

        function autoNumber() {
            $.ajax({
                type: 'GET',
                url: '{{url('/transactionSales/getSalesCode')}}',
                dataType: 'JSON',
                success: function (res) {
                    $('#salesCode').val(res.code);
                }
            });
        }
    </script>
@endsection