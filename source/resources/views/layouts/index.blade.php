<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Site Properties -->
    <title>Semantic - UI</title>
    <link rel="stylesheet" href="{{ asset('assets/Semantic-UI/semantic.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/Semantic-UI/calendar.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/Semantic-UI/Semantic-UI-Alert.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/DataTables/css/dataTables.semanticui.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/DataTables/extension/button/buttons.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/DataTables/extension/select/select.semanticui.min.css')}}"/>
    @yield('css')
</head>
<body>
<div class="ui blue inverted huge menu">
    @if (Auth::user())
        <a class="item" href="{{url('/dashboard')}}">Home</a>

        @if(Auth::user()->isAdmin())
        <div class="ui dropdown item">
            Admin
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="{{url('/manageUser')}}">User Manage</a>
            </div>
        </div>
        @endif

        <div class="ui dropdown item">
            Goods
            <i class="dropdown icon"></i>
            <div class="ui vertical menu">
                <div class="ui dropdown item">Item Manage<i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{url('/manageItemType')}}">Item Type</a>
                        <a class="item" href="{{url('/manageItem')}}">Item</a>
                    </div>
                </div>
                <a class="item" href="{{url('/manageSupplier')}}">Supplier</a>
            </div>
        </div>
        <div class="ui dropdown item">
            Sales
            <i class="dropdown icon"></i>
            <div class="ui vertical menu">
                <div class="ui dropdown item">Transaction<i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{url('/transactionSales')}}">Sales</a>
                        <a class="item" href="{{url('/transactionPurchase')}}">Purchase</a>
                    </div>
                </div>
                <div class="ui dropdown item">History Transaction<i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{url('/transactionRecordSales')}}">Sales</a>
                        <a class="item" href="{{url('/transactionRecordPurchase')}}">Purchase</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="right menu">
        @if (Auth::user())
            <div class="ui dropdown item">Welcome, {{Auth::user()->username}} !<i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" id="btnShowProfile">Edit Profile</a>
                    <a class="item" id="btnLogout">Logout</a>
                </div>
            </div>
        @else
            <div class="item">
                <div class="ui inverted button" id="showModal">Login</div>
            </div>
        @endif
    </div>
</div>


<div class="twelve wide column">
    <div class="ui container">
        @yield('content')
    </div>
</div>


<!-- modal -->
@if (Auth::user())
    <div class="ui modal" id="modalEdit">
        <i class="close icon"></i>
        <div class="header">Edit</div>
        <div class="content">
            <form class="ui form" id="formEdit">
                {!! csrf_field() !!}
                <div class="field" id="usernameCheck">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" id="usernameUpd"
                           value="{{Auth::user()->username}}">
                    <div class="ui pointing red basic label hidden" id="usernameUpdError">Username already taken !!
                    </div>
                </div>
                <div class="field" id="pwdCheck">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" id="passwordOld">
                    <div class="ui pointing red basic label hidden" id="passwordOldError">Enter the current password
                        !!
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
                    <input type="email" name="email" placeholder="Email" id="emailUpd" value="{{Auth::user()->email}}">
                </div>
                <div class="field">
                    <label>Role</label>
                    <select class="ui selection dropdown" id="roleUpd" name="role">
                        @if (Auth::user()->role === 'Admin')
                            <option value="" disabled>Role</option>
                            <option value="Admin" selected>Admin</option>
                            <option value="User">User</option>
                        @else
                            <option value="" disabled>Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User" selected>User</option>
                        @endif
                    </select>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui negative ui button ">Cancel</button>
            <button class="ui positive ui button" id="btnEdit">Update</button>
        </div>
    </div>
@else
    <div class="ui modal" id="modalLogin">
        <i class="close icon"></i>
        <div class="header">Login</div>
        <div class="content">
            <form class="ui form" id="form">
                {{ csrf_field() }}
                <div class="field" id="usernameField">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" id="username">
                </div>
                <div class="field" id="passwordField">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" id="password">
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui negative ui button">Cancel</button>
            <button class="ui positive ui button" id="btnLogin">Login</button>
        </div>
    </div>
@endif
<!-- End of Modal -->

</body>
<footer>
    <script src="{{ asset('assets/jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/Semantic-UI/semantic.min.js')}}"></script>
    <script src="{{ asset('assets/Semantic-UI/calendar.min.js')}}"></script>
    <script src="{{ asset('assets/Semantic-UI/Semantic-UI-Alert.js')}}"></script>
    <script src="{{ asset('assets/DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/js/dataTables.semanticui.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/jszip.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/button/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/DataTables/extension/select/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('assets/Moment/moment.min.js')}}"></script>
    <script src="{{ asset('assets/Accounting/accounting.min.js')}}"></script>
    <script src="{{ asset('assets/Highchart/highcharts.js')}}"></script>
    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        var hide = (function (id) {
            $(id).removeClass('hidden');
            setTimeout(function () {
                $(id).addClass('hidden')
            }, 4000)
        });

        @if (Auth::user())
        function validationFormEdit() {

            $('#passwordOld').keyup(function () {
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{url('/user/checkPassword')}}',
                        data: $('#formEdit').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.status) {
                                $('#pwdCheck').removeClass('error');
                                $('#passwordOldError').addClass('hidden');
                            } else {
                                $('#pwdCheck').addClass('error');
                                $('#passwordOldError').removeClass('hidden');
                            }
                        }, error: function (err) {
                            console.error(err);
                        }, complete: function () {
                        }
                    });
                }, 1000);
            });

            $('#usernameUpd').keyup(function () {
                delay(function () {
                    $.ajax({
                        type: 'GET',
                        url: '{{url('/user/checkUsername')}}',
                        data: $('#formEdit').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            if ((!res.status) || ('{{Auth::user()->username}}' === $('#usernameUpd').val())) {
                                $('#usernameCheck').removeClass('error');
                                $('#usernameUpdError').addClass('hidden');
                            } else {
                                $('#usernameCheck').addClass('error');
                                $('#usernameUpdError').removeClass('hidden');
                            }
                        }, error: function (err) {
                            console.error(err);
                        }, complete: function () {

                        }
                    });
                }, 1000);
            });

            $('#password2').keyup(function () {
                if ($('#password1').val() !== $('#password2').val()) {
                    $('.passwordError').removeClass('hidden');
                    $('.pwdConfirm').addClass('error');
                } else {
                    $('.passwordError').addClass('hidden');
                    $('.pwdConfirm').removeClass('error');
                }
            });

            $('#password1').keyup(function () {
                if ($('#password1').val() !== $('#password2').val()) {
                    $('.passwordError').removeClass('hidden');
                    $('.pwdConfirm').addClass('error');
                } else {
                    $('.passwordError').addClass('hidden');
                    $('.pwdConfirm').removeClass('error');
                }
            });
        }
        @endif


        $(function () {
            @if (Auth::user())
            $('.ui.dropdown').dropdown();
            $('#btnShowProfile').on('click', function () {
                $('#modalEdit').modal('show');
            });

            validationFormEdit();

            $('#btnEdit').on('click', function () {
                $('#formEdit').submit(function (e) {
                    e.preventDefault();
                });
                if (($('#pwdCheck').hasClass('error')) || ($('.pwdConfirm').hasClass('error')) || ($('#usernameCheck').hasClass('error'))) {
                    console.log('error');
                    return false;
                } else {
                    $.ajax({
                        type: 'PUT',
                        url: '{{url('/user/editUser')}}',
                        data: $('#formEdit').serialize(),
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.status) {
                                location.reload();
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
                        }, error: function (err) {
                            console.error(err);
                        }, complete: function () {
                            $("#formEdit")[0].reset();
                        }
                    });
                }
            });

            $('#btnLogout').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '{{url('/user/logout')}}',
                    dataType: "JSON",
                    success: function (res) {
                        if (res.status) {
                            location.href = '{{url('/')}}';
                        }
                    }
                });
            });

            @else
            $('#showModal').on('click', function () {
                $('#modalLogin').modal('show');
            });

            $('#btnLogin').on('click', function () {
                $('#form').submit(function (e) {
                    e.preventDefault();
                });
                if ($('#username').val() === '') {
                    $('#usernameField').addClass('error');
                    return false;
                } else if ($('#password').val() === '') {
                    $('#passwordField').addClass('error');
                    return false;
                } else {
                    $.ajax({
                        type: 'POST',
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        url: '{{url('/user/authenticate')}}',
                        success: function (res) {
                            if (res.status) {
                                $.uiAlert({
                                    textHead: 'You may now log-in with the username you have chosen', // header
                                    text: 'You may now log-in with the username you have chosen', // Text
                                    bgcolor: '#19c3aa', // background-color
                                    textcolor: '#fff', // color
                                    position: 'top-center',// position . top And bottom ||  left / center / right
                                    icon: 'checkmark box', // icon in semantic-UI
                                    time: 3, // time
                                });
                                location.href = '{{url('/dashboard')}}';
                            } else {
                                $.uiAlert({
                                    textHead: 'Error',
                                    text: 'Username or Password not recognized !',
                                    bgcolor: '#DB2828',
                                    textcolor: '#fff',
                                    position: 'top-center', // top And bottom ||  left / center / right
                                    icon: 'remove circle',
                                    time: 3
                                });
                            }
                        },
                        error: function (err) {
                            console.error(err);
                        },
                        complete: function () {
                            $('#usernameField').removeClass('error');
                            $('#passwordField').removeClass('error');
                            $("#form")[0].reset();
                        }
                    });
                }
            });
            @endif
        })
        ;
    </script>
    @yield('script')
</footer>
</html>