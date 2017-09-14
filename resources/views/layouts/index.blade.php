<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Site Properties -->
    <title>Login Example - Semantic</title>
    <link rel="stylesheet" href="{{ asset('assets/Semantic-UI/semantic.min.css')}}"/>
</head>
<body>
<div class="ui large menu">
    @if (Auth::user())
        <a class="active item">Home</a>
        <a class="item">Messages</a>
    @endif

    <div class="right menu">
        @if (Auth::user())
            <div class="ui dropdown item">Hai, {{Auth::user()->username}} !<i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" id="btnEditProfile">Edit Profile</a>
                    <a class="item" id="btnLogout">Logout</a>
                </div>
            </div>
        @else
            <div class="item">
                <div class="ui primary button" id="showModal">Login</div>
            </div>
        @endif
    </div>
</div>

@yield('content')


<!-- modal -->
@if (Auth::user())
    <div class="ui modal" id="modalEdit">
        <i class="close icon"></i>
        <div class="header">Login</div>
        <div class="content">
            <form class="ui form" id="form">
                {{ csrf_field() }}

                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" id="username">
                </div>
                <div class="field">
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
@else
    <div class="ui modal" id="modalLogin">
        <i class="close icon"></i>
        <div class="header">Login</div>
        <div class="content">
            <form class="ui form" id="form">
                {{ csrf_field() }}

                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" id="username">
                </div>
                <div class="field">
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
    <script>
        $(function () {
            @if (Auth::user())
            $('.ui.dropdown').dropdown();

            $('#btnEditProfile').on('click', function () {
                $('#modalEdit').modal('show');
            });

            $('#btnLogout').on('click', function () {
                {{Auth::logout()}};
                location.reload();
            });

            @else
            $('#showModal').on('click', function () {
                $('#modalLogin').modal('show');
            });

            $('#btnLogin').on('click', function () {
                $('#form').submit(function (e) {
                    e.preventDefault();
                });
                $.ajax({
                    type: 'POST',
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    url: '{{url('/user/authenticate')}}',
                    success: function (res) {
                        if (res.status) {
                            location.href = '{{url('/dashboard')}}';
                        }
                    },
                    error: function (err) {
                        console.error(err);
                    },
                    complete: function () {
                        $("#form")[0].reset();
                    }
                });
            });
            @endif
        });
    </script>
    @yield('script')
</footer>
</html>