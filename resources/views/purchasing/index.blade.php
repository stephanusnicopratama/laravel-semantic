@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="write icon"></i>
        Purchase Transaction
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formPurchase">
            {!! csrf_field() !!}

            <input type="text" name="id_purchase" id="id_purchase" hidden>

            <div class="field">
                <div class="field">
                    <label>Item</label>
                    <select class="ui fluid dropdown" id="selectItem" name="item"></select>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Qty</label>
                        <input type="number" name="qty" id="qty">
                    </div>
                    <div class="field">
                        <label>Price</label>
                        <input type="number" name="price" id="price">
                    </div>
                </div>
                <div class="field">
                    <label>Supplier</label>
                    <select class="ui fluid dropdown" id="selectSupplier" name="supplier"></select>
                </div>
                <div class="field">
                    <label>Notes</label>
                    <textarea id="notes" name="notes"></textarea>
                </div>

                <button class="ui primary button" id="btnInsert" type="submit">Insert</button>
                <button class="ui button" id="btnCancel" type="reset" onclick="cancel()" style="display: none;">Cancel
                </button>
            </div>
        </form>
    </div>

    <h3 class="ui top attached header">
        <i class="table icon"></i>
        Purchase Table
    </h3>
    <div class="ui attached segment" id="divTable">
        <table class="ui celled table" cellspacing="0" width="100%" id="tblPurchase"></table>
    </div>
@endsection

@section('script')
    <script>
        var item = '';
        var supplier = '';
        $(function () {
            $.ajax({
                url: '{{url('/manageItem/getAllData')}}',
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    $.each(res.data, function (key, value) {
                        item = item + '<option value="' + value.item_code + '">' + value.item_name + '</option>';
                    });
                    $('#selectItem').html(item);
                }
            });

            $.ajax({
                url: '{{url('/manageSupplier/getAllData')}}',
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    $.each(res.data, function (key, value) {
                        supplier = supplier + '<option value="' + value.id_supplier + '">' + value.name_supplier + '</option>';
                    });
                    $('#selectSupplier').html(supplier);
                }
            });

            $('#formPurchase').submit(function (e) {
                e.preventDefault();
                var data = $('#formPurchase').serialize();
                if ($('#btnInsert').text() === 'Insert') {
                    insert(data);
                } else {
                    update(data);
                }
            });

            var table = $('#tblPurchase').DataTable({
                ajax: {
                    type: 'GET',
                    url: '{{url('/transactionPurchase/getAllPurchase')}}',
                },
                columns: [
                    {
                        title: 'Action', data: 'item_code', render: function (data) {
                        return '<div class="ui buttons">' +
                            '<button class="ui positive button" id="' + data + '">Edit</button>' +
                            '<div class="or"></div>' +
                            '<button class="ui negative button" id="' + data + '">Delete</button>' +
                            '</div>';
                    }
                    },
                    {title: 'Qty', data: 'qty'},
                    {title: 'Price', data: 'price'},
                    {title: 'Notes', data: 'notes'},
                    {title: 'Date', data: 'date'},
                ]
            });
        });

        function insert(data) {
            $.ajax({
                type: 'POST',
                data: data,
                dataType: 'JSON',
                url: '{{url('/transactionPurchase/insertPurchase')}}',
                success: function (res) {
                    console.log(res);
                    $('#formPurchase')[0].reset();
                    $('#tblPurchase').DataTable().ajax.reload();
                }
            });
        }

        function update(data) {
            console.log('update' + data);
        }

        function cancel() {
            $('#btnInsert').text('Insert');
            $('#btnCancel').css('display', 'none');
        }
    </script>
@endsection
