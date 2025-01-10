@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('createpayment') }}">
                        @csrf

                        <div class="form-group">
                            <label for="amount">Enter Payment Amount (Price: {{ $payment->registration_price }}):</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3">Submit Payment</button>

                        @if (session('error'))
                            <div class="alert alert-danger mt-3" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>

                    @if (session('overpaid'))
                        <form method="POST" action="{{ route('overpayment') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="overpaid_amount" value="{{ session('overpaid') }}">
                            <button type="submit" name="action" value="yes" class="btn btn-success">Yes, add to wallet</button>
                            <button type="submit" name="action" value="no" class="btn btn-danger">No, re-enter amount</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
