@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="archive icon"></i>
        Item Manage
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formItem">
            <div class="field">

                {!! csrf_field() !!}

                <input type="text" name="id" id="id" hidden/>

                <div class="two fields">
                    <div class="field" id="codeField">
                        <label>Code</label>
                        <input type="text" name="code" placeholder="Item Code" id="code" required>
                        <div class="ui pointing red basic label hidden" id="codeError">Code item already exist !!
                        </div>
                    </div>
                    <div class="field">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Item Name" id="name" required>
                    </div>
                </div>
                <div class="field">
                    <label>Type</label>
                    <select class="ui fluid dropdown" id="selectType" name="type_item"></select>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" placeholder="Selling Price"
                               required>
                    </div>
                    <div class="field">
                        <label>Purchase Price</label>
                        <input type="number" name="purchase_price" id="purchase_price" placeholder="Purchase Price"
                               required>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Quantity</label>
                        <input type="number" name="qty" id="qty" placeholder="Stock Qty" required>
                    </div>
                    <div class="field">
                        <label>Pieces</label>
                        <input type="text" name="pcs" id="pcs" placeholder="Pieces" required>
                    </div>
                </div>
                <div class="field">
                    <label>Supplier</label>
                    <select class="ui fluid dropdown" id="selectSupplier" name="supplier"></select>
                </div>
                <button class="ui primary button" tabindex="0" type="submit" id="btnInsert">Insert</button>
                <button class="ui button" type="button" id="btnCancel" style="display: none">Cancel</button>
            </div>
        </form>
    </div>

    <h3 class="ui top attached header">
        <i class="table icon"></i>
        Item Table
    </h3>
    <div class="ui attached segment" id="divTable">
        <table class="ui celled table" cellspacing="0" width="100%" id="tblItems"></table>
    </div>

    {{--alert delete --}}
    <div class="ui tiny modal">
        <div class="header">Delete</div>
        <div class="content">
            <p>Are you sure want to delete?</p>
        </div>
        <div class="actions">
            <div class="ui approve blue button">I'm sure</div>
            <div class="ui negative red button">Cancel</div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            var item_type = '';
            var supplier = '';
            $.ajax({
                url: '{{url('/manageItemType/getAllItem')}}',
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    $.each(res.data, function (key, value) {
                        item_type = item_type + '<option value="' + value.id_type + '">' + value.name_type + '</option>';
                    });
                    $('#selectType').html(item_type);
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

            $('#formItem').submit(function (e) {
                e.preventDefault();
                $('#formItem').addClass('loading');
                $('#divTable').addClass('loading');
                if ($('#btnInsert').text() === 'Insert') {
                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manageItem/insertNewData')}}',
                        data: $('#formItem').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            table.ajax.reload();
                            $('#formItem').removeClass('loading');
                            $('#divTable').removeClass('loading');
                            $('#formItem')[0].reset();
                        }
                    });
                } else {
                    $.ajax({
                        type: 'PUT',
                        url: '{{url('/manageItem/editData')}}',
                        data: $('#formItem').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            $('#formItem').removeClass('loading');
                            $('#divTable').removeClass('loading');
                            $('#formItem')[0].reset();
                            $('#code').removeAttr('readonly');
                            $('#btnInsert').text('Insert');
                            $('#btnCancel').css('display', 'none');
                            table.ajax.reload();
                        }
                    });
                }
            });

            var table = $('#tblItems').DataTable({
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: '{{url('/manageItem/getAllData')}}',
                    dataType: 'JSON'
                },
                columns: [{
                    title: 'Code', data: 'item_code',
                }, {
                    title: 'Name', data: 'item_name',
                }, {
                    title: 'Type', data: 'name_type',
                }, {
                    title: 'Stock', data: 'item_stock',
                }, {
                    title: 'Pieces', data: 'piece',
                }, {
                    title: 'Selling Price', data: 'selling_price',
                }, {
                    title: 'Purchase Price', data: 'purchase_price',
                }, {
                    title: 'Supplier', data: 'name_supplier',
                }, {
                    title: 'Action', data: 'item_code', render: function (data) {
                        return '<div class="ui buttons">' +
                            '<button class="ui positive button" id="' + data + '">Edit</button>' +
                            '<div class="or"></div>' +
                            '<button class="ui negative button" id="' + data + '">Delete</button>' +
                            '</div>';
                    }
                }]
            });

            $('#tblItems tbody').on('click', 'tr td button.ui.positive.button', function () {
                var code = $(this).attr('id');
                $('#formItem').addClass('loading');
                $('#btnInsert').text('Update');
                $.ajax({
                    type: 'GET',
                    url: '{{url('/manageItem/getEditData')}}',
                    data: {_token: $('[name="_token"]').val(), code: code},
                    dataType: 'JSON',
                    success: function (res) {
                        $('#code').val(res.item_code);
                        $('#name').val(res.item_name);
                        $('#qty').val(res.item_stock);
                        $('#pcs').val(res.piece);
                        $('#selling_price').val(res.selling_price);
                        $('#purchase_price').val(res.purchase_price);
                        $('#code').attr('readonly', '');
                        $('#selectType').dropdown('set selected', res.item_type);
                        $('#selectSupplier').dropdown('set selected', res.supplier);
                        $('#btnCancel').css('display', 'inline');
                        $('#formItem').removeClass('loading');
                    }
                });
            });

            $('#btnCancel').on('click', function () {
                $('#formItem')[0].reset();
                $('#code').removeAttr('readonly');
                $('#btnInsert').text('Insert');
                $('#btnCancel').css('display', 'none');
            });

            $('#tblItems tbody').on('click', 'tr td button.ui.negative.button', function () {
                var code = $(this).attr('id');
                $('.ui.tiny.modal').modal({
                    onApprove: function () {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{url('/manageItem/deleteData')}}',
                            data: {_token: $('[name="_token"]').val(), code: code},
                            success: function (res) {
                                console.log(res);
                                table.ajax.reload();
                            }
                        })
                    }
                }).modal('show');
            });

            $('#code').keyup(function () {
                delay(function () {
                    $.ajax({
                        type: 'GET',
                        url: '{{url('/manageItem/checkCodeItem')}}',
                        data: {_token: $('[name="_token"]').val(), code: $('#code').val()},
                        dataType: 'JSON',
                        success: function (res) {
                            if (!res) {
                                $('#codeField').addClass('error');
                                $('#codeError').removeClass('hidden');
                            } else {
                                $('#codeError').addClass('hidden');
                                $('#codeField').removeClass('error');
                            }
                        }
                    });
                }, 1000);
            });

            $('#code').change(function () {
                delay(function () {
                    $.ajax({
                        type: 'GET',
                        url: '{{url('/manageItem/checkCodeItem')}}',
                        data: {_token: $('[name="_token"]').val(), code: $('#code').val()},
                        dataType: 'JSON',
                        success: function (res) {
                            if (!res) {
                                $('#codeField').addClass('error');
                                $('#codeError').removeClass('hidden');
                            } else {
                                $('#codeError').addClass('hidden');
                                $('#codeField').removeClass('error');
                            }
                        }
                    });
                }, 1000);
            });

        });
    </script>
@endsection