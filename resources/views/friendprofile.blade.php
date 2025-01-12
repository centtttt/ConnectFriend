@extends('layouts.app')

@section('content')
    <div class="container mt-1">
        <header class="text-center mb-4">
            <h1>Profile</h1>
            <p>Connecting with passion and purpose discover the person behind the profile.</p>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h3 class="mb-0">Profile Details</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($users as $user)
                            <div class="text-center mb-4">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset($user->profile->profileURL ? 'storage/' . $user->profile->profileURL : 'images/userdummy.png') }}" alt="error" class="rounded-circle shadow m-4 mb-1" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <h5 class="text-center fw-bold mb-3">{{ $user->name }}</h5>

                            <div class="text-center">
                                <strong class="fw-bold">Job Fields:</strong>
                                <ul class="list-unstyled">
                                    @foreach ($jobfield as $jf)
                                        <li class="badge bg-primary text-white mx-1">{{ $jf->jobfieldname }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Gender:</strong> {{ $user->profile->gender }}
                                </li>
                                <li class="list-group-item">
                                    <strong>LinkedIn:</strong> 
                                    <a href="{{ $user->profile->linkedin }}" target="_blank"> {{ $user->profile->linkedin }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Mobile Number:</strong> {{ $user->profile->mobile_number }}
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
