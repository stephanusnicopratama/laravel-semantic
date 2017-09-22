@extends('layouts/index')

@section('content')
    <h4 class="ui horizontal divider header"><i class="write square icon"></i>Form</h4>
    <form class="ui form" id="formItemType">
        {{csrf_field()}}

        <input type="text" id="idCheck" name="idCheck" hidden>

        <div class="field" id="typeDiv">
            <label>Type Name</label>
            <input type="text" id="itemType" name="type_name" placeholder="Item Type Name" required>
            <div class="ui pointing red basic label hidden" id="itemTypeLabel">Field cannot be empty !!</div>
        </div>
        <button class="ui button primary" type="submit" id="btnItem">Insert</button>
        <button class="ui disabled button" type="button" id="btnItemCancel">Cancel</button>
    </form>

    <h4 class="ui horizontal divider header"><i class="table icon"></i>List Item Type</h4>
    <table class="ui celled table" cellspacing="0" width="100%" id="tblItemType"></table>

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
        var table = $('#tblItemType').DataTable({
            ajax: {
                url: '{{url('/manageItemType/getAllItem')}}',
                type: 'GET',
                dataType: 'JSON'
            },
            columns: [
                {title: 'Type Name', data: 'name_type'},
                {
                    title: 'Created', data: 'updated_at', render: function (data) {
                    return moment(data).format('DD-MMM-Y, H:mm');
                }
                },
                {
                    title: 'Updated', data: 'created_at', render: function (data) {
                    return moment(data).format('DD-MMM-Y, H:mm');
                }
                },
                {
                    title: 'Action', data: 'id_type', render: function (data, type, full, meta) {
                    return '<div class="ui buttons">' +
                        '<button class="ui positive button" id="' + data + '">Edit</button>' +
                        '<div class="or"></div>' +
                        '<button class="ui negative button" id="' + data + '">Delete</button>' +
                        '</div>';
                }
                }]
        });

        $('#tblItemType tbody').on('click', 'button.ui.positive.button', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                data: {_token: $('[name="_token"]').val(), id: id},
                url: '{{url('/manageItemType/getEditItem')}}',
                dataType: 'JSON',
                success: function (res) {
                    $('#idCheck').val(res.id_type)
                    $('#itemType').val(res.name_type);
                }, error: function (err) {
                    console.error(err);
                }, complete: function () {
                    $('#btnItem').text('Update');
                    $('#btnItemCancel').removeClass('disabled');
                }
            });
        });

        $('#tblItemType tbody').on('click', 'button.ui.negative.button', function () {
            $('.ui.tiny.modal').modal({
                onApprove: function () {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{url('/manageItemType/deleteData')}}',
                        dataType: 'JSON',
                        data: {_token: $('[name="_token"]').val(), id: id},
                        success: function (res) {
                            console.log(res);
                            table.ajax.reload();
                        }
                    });
                }
            }).modal('show');
            var id = $(this).attr('id');

        });

        $('#itemType').on('keyup', function () {
            if ($('#itemType').val() === "") {
                $('#typeDiv').addClass('error');
                $('#itemTypeLabel').removeClass('hidden');
                $('#formItemType').removeClass('loading');
            } else {
                $('#formItemType').removeClass('loading');
                $('#itemTypeLabel').addClass('hidden');
                $('#typeDiv').removeClass('error');
            }
        });

        $('#formItemType').submit(function (e) {
            e.preventDefault();
            $('#formItemType').addClass('loading');
            if ($('#itemType').val() === "") {
                $('#typeDiv').addClass('error');
                $('#itemTypeLabel').removeClass('hidden');
                $('#formItemType').removeClass('loading');
            } else {
                $('#typeDiv').removeClass('error');
                if ($('#btnItem').text() === 'Insert') {
                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manageItemType/insertNewData')}}',
                        data: $('#formItemType').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            console.log(res);
                            table.ajax.reload();
                        }, error: function (error) {
                            console.error(error);
                        }, complete: function () {
                            $('#formItemType').removeClass('loading');
                            $('#itemTypeLabel').addClass('hidden');
                        }
                    });
                } else {
                    $.ajax({
                        type: 'PUT',
                        url: '{{url('/manageItemType/updateItem')}}',
                        data: $('#formItemType').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            console.log(res);
                            table.ajax.reload();
                        }, error: function (error) {
                            console.error(error);
                        }, complete: function () {
                            $('#formItemType').removeClass('loading');
                            $('#itemTypeLabel').addClass('hidden');
                        }
                    });
                }
            }
        });

        $('#btnItemCancel').on('click', function () {
            $('#formItemType')[0].reset();
            $('#btnItem').text('Insert');
            $('#btnItemCancel').addClass('disabled');
        });
    </script>
@endsection