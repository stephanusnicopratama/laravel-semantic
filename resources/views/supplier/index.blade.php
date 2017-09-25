@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="address card outline icon"></i>
        Supplier Manage
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formSupplier">
            {!! csrf_field() !!}

            <input type="text" id="idSupplier" name="id" hidden>

            <div class="field">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Supplier Name" id="name" required>
                </div>
                <div class="field">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Supplier Address" id="address" required>
                </div>
                <div class="field">
                    <label>Telephone</label>
                    <input type="number" name="telephone" placeholder="Supplier Telephone" id="telp" required>
                </div>
                <button class="ui primary button" id="btnInsert" tabindex="0" type="submit">Insert</button>
                <button class="ui button" id="btnCancel" type="button" style="display: none;">Cancel</button>
            </div>
        </form>
    </div>

    <div class="ui negative message hidden" id="msg">
        <i class="close icon" id="close"></i>
        <div class="header">
            Error !!
        </div>
        <p>Can't delete data because have relation with item..</p>
    </div>
    <h3 class="ui top attached header">
        <i class="table icon"></i>
        Supplier Table
    </h3>
    <div class="ui attached segment" id="supplierSection">
        <table class="ui celled table" cellspacing="0" width="100%" id="tblSupplier"></table>
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
            var table = $('#tblSupplier').DataTable({
                ajax: {
                    type: 'GET',
                    url: '{{url('/manageSupplier/getAllData')}}',
                },
                columns: [
                    {title: 'Name', data: 'name_supplier'},
                    {title: 'Address', data: 'address_supplier'},
                    {title: 'Telephone', data: 'telephone_supplier'},
                    {
                        title: 'Action', data: 'id_supplier', render: function (data) {
                        return '<div class="ui buttons">' +
                            '<button class="ui positive button" id="' + data + '">Edit</button>' +
                            '<div class="or"></div>' +
                            '<button class="ui negative button" id="' + data + '">Delete</button>' +
                            '</div>';
                    }
                    }
                ]
            });

            $('#tblSupplier tbody').on('click', '.ui.positive.button', function () {
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: '{{url('/manageSupplier/getEditData')}}',
                    dataType: 'JSON',
                    data: {_token: $('[name="_token"]').val(), id: id},
                    success: function (res) {
                        $('#idSupplier').val(res.id_supplier);
                        $('#name').val(res.name_supplier);
                        $('#address').val(res.address_supplier);
                        $('#telp').val(res.telephone_supplier);
                        $('#btnCancel').css('display', 'inline');
                        $('#btnInsert').text('Update');
                    }
                });
            });

            $('#btnCancel').on('click', function () {
                $('#formSupplier')[0].reset();
                $('#btnInsert').text('Insert');
                $('#btnCancel').css('display', 'none');
            });

            $('#tblSupplier tbody').on('click', '.ui.negative.button', function () {
                var id = $(this).attr('id');
                $('.ui.tiny.modal').modal({
                    onApprove: function () {
                        $('#supplierSection').addClass('loading');
                        $.ajax({
                            type: 'DELETE',
                            url: '{{url('/manageSupplier/deleteData')}}',
                            dataType: 'JSON',
                            data: {_token: $('[name="_token"]').val(), id: id},
                            success: function (res) {
                                console.log(res);
                                table.ajax.reload();
                            }, error: function () {
                                hide('#msg');
                            },
                            complete: function () {
                                $('#supplierSection').removeClass('loading');
                            }
                        });
                    }
                }).modal('show');
            });

            $('#close').on('click', function () {
                $('#msg').addClass('hidden');
            });

            $('#formSupplier').submit(function (e) {
                e.preventDefault();
                $('#formSupplier').addClass('loading');
                $('#supplierSection').addClass('loading');
                if ($('#btnInsert').text() === 'Insert') {
                    $.ajax({
                        type: 'POST',
                        data: $('#formSupplier').serialize(),
                        dataType: 'JSON',
                        url: '{{url('/manageSupplier/insertNewData')}}',
                        success: function (res) {
                            table.ajax.reload();
                        },
                        complete: function () {
                            $('#formSupplier').removeClass('loading');
                            $('#supplierSection').removeClass('loading');
                        }
                    });
                } else {
                    $.ajax({
                        type: 'PUT',
                        data: $('#formSupplier').serialize(),
                        dataType: 'JSON',
                        url: '{{url('/manageSupplier/editData')}}',
                        success: function (res) {
                            console.log(res);
                            table.ajax.reload();
                        },
                        complete: function () {
                            $('#formSupplier').removeClass('loading');
                            $('#supplierSection').removeClass('loading');
                        }
                    });
                }
            });

        });
    </script>
@endsection