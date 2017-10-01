@extends('layouts/index')

@section('content')

    <h3 class="ui top attached header">
        <i class="address card outline icon"></i>
        Master Transaction
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

@endsection

@section('script')

@endsection