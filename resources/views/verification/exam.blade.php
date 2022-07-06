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
                                        <select data-placeholder="Select Courses" name="courses[]" class="form-control select2 @error('courses') is-invalid @enderror" multiple>
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}" {{ collect(old('courses'))->contains($course->id)?'selected':'' }}>{{ $course->name }} - {{ $course->code }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('courses')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Venue</label>
                                        <input type="text" value="{{ old('venue') }}" class="form-control @error('venue') is-invalid @enderror" name="venue">

                                        @error('venue')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Select Date</label>
                                        <input type="datetime-local" value="{{ \Carbon\Carbon::parse(old('sit_date', now()))->format('Y-m-d\TH:i') }}" class="form-control @error('sit_date') is-invalid @enderror" name="sit_date">

                                        @error('sit_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
