@extends('layouts.app')

@section('content')
    <div class="container mt-1">
        <header class="text-center mb-4">
            <h1>@lang('bahasa.hometittle')</h1>
            <p>@lang('bahasa.homesubtittle')</p>
        </header>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('home.index') }}" method="GET">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Filter by Gender</h5>
                    <select class="form-select" id="genderFilter" name="genderFilter" onchange="this.form.submit()">
                        <option value="" {{ request('genderFilter') == '' ? 'selected' : '' }}>All</option>
                        <option value="Male" {{ request('genderFilter') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('genderFilter') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <h5>Search by Field of Work</h5>
                    <input type="text" id="fieldSearch" name="fieldSearch" class="form-control" placeholder="Enter field of work" value="{{ request('fieldSearch') }}">
                </div>
            </div>
        </form>

        <div class="row">
            @foreach ($dataUsers as $user)
                <div class="col-md-4 mb-3 user-card" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';">
                    <div class="card h-100">
                        <a href="{{ route('friend-profile.show', $user->id) }}">
                            <img src="{{ asset($user->profile->profileURL ? 'storage/' . $user->profile->profileURL : 'images/userdummy.png') }}" class="card-img-top" alt="error" style="width: 100%; height: 20rem; object-fit: cover;">
                        </a>
                        
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title">{{ $user->name }}</h4>   
                            <h6 class="card-title">({{ $user->gender }})</h6>   
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

                            <div class="mt-auto pt-4 gap-3 d-flex justify-content-center align-items-end">
                                <a href="{{ route('friend-profile.show', $user->id) }}">
                                    <button class="btn btn-outline-primary">View Profile</button>
                                </a>
                                <form action="{{ route('home.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-outline-success">👍</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>  
@endsection
