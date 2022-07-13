@extends('layouts.app')

@push('title')
    Allocate Lecturer
@endpush

@section('content')
    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <form action="{{ route('allocate.lecturers.store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select data-placeholder="Select Courses" multiple name="courses[]" class="form-control select2 @error('course') is-invalid @enderror">
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{ $course->name }} - {{ $course->code }}</option>
                                            @endforeach
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
                                        <label class="control-label">Lecturer</label>
                                        <select data-placeholder="Select method of enrrollement" name="lecturer" class="form-control @error('lecturer') is-invalid @enderror">
                                            <option value="{{ null }}">Choose lecturer</option>
                                            @foreach ($lecturers as $lecturer)
                                                <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('lecturer')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Allocate <i class="ri-login-box-line align-middle"></i></button>
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
