@extends('layouts/index')

@section('content')
    <div class="ui primary top attached button" id="btnShowModalNewUser" tabindex="0">Add New User</div>
    <div class="ui attached segment">
        <table id="tblUser" class="ui celled table" cellspacing="0" width="100%"></table>
    </div>

    {{--alert delete --}}
    <div class="ui tiny modal">
        <div class="header">Delete</div>
        <div class="content">
            <p>Are you sure want to delete?</p>
        </div>
        <div class="actions">
            <div class="ui cancel red button">Cancel</div>
            <div class="ui approve blue button">I'm sure</div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="ui modal" id="modalNewUser">
        <i class="close icon"></i>
        <div class="header" id="titleUser"></div>
        <div class="content">
            <form class="ui form" id="formUser">
                {{ csrf_field() }}

                <input type="text" name="id" id="id" style="display: none">

                <div class="field" id="usernameCheck">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" id="username">
                    <div class="ui pointing red basic label hidden" id="usernameError">Username already taken !!
                    </div>
                </div>
                <div class="field pwdConfirm">
                    <label>New Password</label>
                    <input type="password" name="password1" placeholder="New Password" id="password1">
                    <div class="ui pointing red basic label hidden passwordError">Password didn't match !!</div>
                </div>
                <div class="field pwdConfirm">
                    <label>Confirm Password</label>
                    <input type="password" name="password2" placeholder="Confirm Password" id="password2">
                    <div class="ui pointing red basic label hidden passwordError">Password didn't match !!</div>
                </div>
                <div class="field">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="Email" id="email">
                </div>
                <div class="field">
                    <label>Role</label>
                    <select class="ui selection dropdown" id="role" name="role">
                            <option value="" selected disabled>Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui negative ui button ">Cancel</button>
            <button class="ui positive ui button" id="btnActionUser"></button>
        </div>
    </div>


    @if (Session::has('alert-success'))
        <li>{!! Session::get('alert-success') !!}</li>
    @endif
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            }
        });

        $(document).ready(function () {
            var table = $('#tblUser').DataTable({
                select: false,
                ajax: {
                    url: '{{url('/manageUser/getAllUser')}}',
                    type: 'GET',
                    dataType: 'JSON'
                },
                columns: [
                    {title: 'Username', data: 'username'},
                    {title: 'Email', data: 'email'},
                    {title: 'Role', data: 'role'},
                    {title: 'Created', data: 'created_at'},
                    {title: 'Last Updated', data: 'updated_at'},
                    {
                        title: 'Action', data: 'id', render: function (data, type, full, meta) {
                        return '<div class="ui buttons">' +
                            '<button class="ui positive button" id="' + data + '">Edit</button>' +
                            '<div class="or"></div>' +
                            '<button class="ui red button" id="' + data + '">Delete</button>' +
                            '</div>';
                    }
                    }
                ]
            });

            $('#tblUser tbody').on('click', 'button.ui.positive.button', function () {
                var id = $(this).attr('id');
                $('#modalNewUser').modal('show');
                $('#btnActionUser').text('Update');
                $('#titleUser').text('Update');
                $.ajax({
                    type: 'GET',
                    data: {id: id},
                    dataType: 'JSON',
                    url: '{{url('/manageUser/getOneUser')}}',
                    success: function (res) {
                        $('#id').val(res[0].id);
                        $('#username').val(res[0].username);
                        $('#email').val(res[0].email);
                        $('#role').dropdown('set selected', res[0].role);
                    }
                });
            });

            $('#tblUser tbody').on('click', 'button.ui.red.button', function () {
                var id = $(this).attr('id');
                $('.tiny.modal').modal({
                    onApprove: function () {
                        $.ajax({
                            type: 'DELETE',
                            data: {id: id},
                            dataType: 'JSON',
                            url: '{{url('/manageUser/deleteUser')}}',
                            success: function (res) {
                                if (res.data) {
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                }).modal('show');
            });

            $('#btnShowModalNewUser').on('click', function () {
                $('#titleUser').text('Insert');
                $('#btnActionUser').text('Insert');
                $("#formUser")[0].reset();
                $('#modalNewUser').modal('show');
            });

            $('#btnActionUser').on('click', function () {
                if($('#btnActionUser').text() === 'Insert') {
                    $('#formUser').submit(function (e) {
                        e.preventDefault();
                    });
                    $.ajax({
                        type: 'POST',
                        data: $('#formUser').serialize(),
                        dataType: 'JSON',
                        url: '{{url('/manageUser/addNewUser')}}',
                        success: function (res) {
                            console.log(res);
                            if (res.status) {
                                table.ajax.reload();
                            }
                        }
                    });
                } else if($('#btnActionUser').text() === 'Update'){
                    $('#formUser').submit(function (e) {
                        e.preventDefault();
                    });
                    $.ajax({
                        type: 'PUT',
                        data: $('#formUser').serialize(),
                        dataType: 'JSON',
                        url: '{{url('/manageUser/updateUser')}}',
                        success: function (res) {
                            if (res) {
                                table.ajax.reload();
                                $.uiAlert({
                                    textHead: 'Info', // header
                                    text: 'Success', // Text
                                    bgcolor: '#55a9ee', // background-color
                                    textcolor: '#fff', // color
                                    position: 'top-right',// position . top And bottom ||  left / center / right
                                    icon: 'info circle', // icon in semantic-UI
                                    time: 3, // time
                                });
                            }
                        }
                    });
                }
            });


        });
    </script>
@endsection