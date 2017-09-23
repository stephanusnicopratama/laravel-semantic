@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="address card outline icon"></i>
        Supplier Manage
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formSupplier">
            {!! csrf_field() !!}

            <div class="field">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Supplier Name">
                </div>
                <div class="field">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Supplier Address">
                </div>
                <div class="field">
                    <label>Telephone</label>
                    <input type="number" name="telephone" placeholder="Supplier Telephone">
                </div>
                <input class="ui button" tabindex="0" type="submit" value="Submit">
            </div>
        </form>
    </div>

    <h3 class="ui top attached header">
        <i class="table icon"></i>
        Supplier Table
    </h3>
    <div class="ui attached segment">
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
                console.log(id);
            });

            $('#tblSupplier tbody').on('click', '.ui.negative.button', function () {
                var id = $(this).attr('id');
                $('.ui.tiny.modal').modal({
                    onApprove: function () {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{url('/manageSupplier/deleteData')}}',
                            dataType: 'JSON',
                            data: {_token: $('[name="_token"]').val(), id: id},
                            success: function (res) {
                                console.log(res);
                                table.ajax.reload();
                            }
                        });
                    }
                }).modal('show');
            });

            $('#formSupplier').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('#formSupplier').serialize(),
                    dataType: 'JSON',
                    url: '{{url('/manageSupplier/insertNewData')}}',
                    success: function (res) {
                        console.log(res);
                        table.ajax.reload();
                    }
                });
            });

        });
    </script>
@endsection