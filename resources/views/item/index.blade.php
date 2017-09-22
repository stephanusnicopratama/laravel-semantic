@extends('layouts/index')

@section('content')
    <h3 class="ui top attached header">
        <i class="archive icon"></i>
        Item Manage
    </h3>
    <div class="ui attached segment">
        <form class="ui form" id="formItem">
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>Code</label>
                        <input type="text" name="code" placeholder="Item Code">
                    </div>
                    <div class="field">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Item Name">
                    </div>
                </div>
                <div class="field">
                    <label>Type</label>
                    <select class="ui fluid dropdown" id="selectType"></select>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Quantity</label>
                        <input type="number" name="qty" id="qty" placeholder="Stok Qty">
                    </div>
                    <div class="field">
                        <label>Pieces</label>
                        <input type="text" name="pcs" id="pcs" placeholder="Pieces">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            var item_type = '';
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
        });
    </script>
@endsection