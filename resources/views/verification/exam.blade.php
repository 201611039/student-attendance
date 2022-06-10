@extends('layouts.app')

@push('title')
    Exam Verification
@endpush

@section('content')
    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <form action="{{ route('verification.exam.check') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Courses</label>
                                        <select data-placeholder="Select Courses" multiple name="courses[]" class="form-control @error('course') is-invalid @enderror">
                                            <option value="{{ null }}">Choose courses</option>
                                        </select>
    
                                        @error('course')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Venue</label>
                                        <input type="text" class="form-control" name="venue">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Select Date</label>
                                        <input type="datetime-local" class="form-control" name="date">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Verify <i class=" ri-user-follow-line align-middle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element.init.js') }}"></script>
@endpush

@push('link')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
