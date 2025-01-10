@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>Welcome to Job Showcase</h1>
            <p>Explore users showcasing their profession and field of work.</p>
        </header>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Filter by Gender</h5>
                <select class="form-select" id="genderFilter">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <h5>Search by Field of Work</h5>
                <input type="text" id="fieldSearch" class="form-control" placeholder="Enter field of work">
            </div>
        </div>

        <div class="row" id="userCards">
            @foreach ($dataUsers as $user)
                <div class="col-md-4 mb-3 user-card">
                    <div class="card h-100">
                        <img src="{{ $user->profileURL }}" class="card-img-top" alt="error">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <div class="pb-2">
                                <p class="card-text">Field of Work: </p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($jobfields as $jf)
                                        @if ($user->id == $jf->user_id)
                                            <div class="border border-success rounded px-3 py-2">
                                                {{ $jf->jobfieldname }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-auto gap-2 d-flex justify-content-end align-items-end">
                                <button class="btn btn-primary">View Profile</button>
                                <button class="btn btn-outline-success">Thumb</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>  
@endsection
