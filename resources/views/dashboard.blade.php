@extends('layouts.app')

@section('content')

@if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Students</p>
                        <h4 class="mb-0">{{ App\Models\Student::all()->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="ri-user-line font-size-24"></i>
                    </div>
                </div>
            </div>

            {{-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                    <span class="text-muted ml-2">From previous period</span>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Lecturers</p>
                        <h4 class="mb-0">{{ App\Models\User::role('lecturer')->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="ri-user-2-line font-size-24"></i>
                    </div>
                </div>
            </div>
            {{-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                    <span class="text-muted ml-2">From previous period</span>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Examination Officer</p>
                        <h4 class="mb-0">{{ App\Models\User::role('exam')->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="ri-briefcase-4-line font-size-24"></i>
                    </div>
                </div>
            </div>
            {{-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                    <span class="text-muted ml-2">From previous period</span>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endif

@endsection
