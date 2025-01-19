@extends('layouts.app')

@section('content')
<div class="container">
    <header class="text-center mb-4">
        <h1>Avatar Shop</h1>
        <p>Purchase your favorite avatar using your coins!</p>
        <p>Your current balance: <strong>1000 coins</strong></p>
    </header>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="" class="card-img-top" alt="error">
                <div class="card-body text-center">
                    <h5 class="card-title">Doraeomo</h5>
                    <p class="card-text">Price: <strong>200 coins</strong></p>
                    <button class="btn btn-primary btn-block">Buy</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
