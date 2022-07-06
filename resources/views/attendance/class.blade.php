@extends('layouts.app')

@push('title')
    Class Attendance
@endpush

@section('content')
    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        @foreach ($errors->all() as $error)
                            @if ($error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>{{ $error }}</strong> 
                                </div>                            
                            @endif
                        @endforeach

                        <form action="{{ route('attendance.class.check') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select data-placeholder="Select Course" name="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                            <option value="{{ null }}">Choose course</option>
                                            @foreach ($lectureCourses as $lectureCourse)
                                                <option value="{{$lectureCourse->course->id}}" {{ old('course_id') == $lectureCourse->course->id?'selected':'' }}>{{ $lectureCourse->course->name }} - {{ $lectureCourse->course->code }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('course_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Method</label>
                                        <select id="method" onchange="checkForm()" data-placeholder="Select method of enrollement" name="method" class="form-control @error('method') is-invalid @enderror">
                                            <option value="{{ null }}">Choose method</option>
                                            <option {{ old('method') == 'fingerprint'? 'selected':'' }} value="fingerprint">By Fingerprint</option>
                                            <option {{ old('method') == 'file'? 'selected':'' }} value="file">By File</option>
                                        </select>
    
                                        @error('method')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 d-none" id="by-file">
                                    <div class="form-group">
                                    <label class="control-label">Excel File</label>
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror"" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="datetime">Date and Time</label>
                                        <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" value="{{ \Carbon\Carbon::parse(old('datetime', now()))->format('Y-m-d\TH:i') }}" name="datetime" id="datetime" aria-describedby="helpId" placeholder="Enter time and date of the period">
    
                                        @error('datetime')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="venue">Venue <small class="text-danger">(optional)</small></label>
                                        <input type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ old('venue') }}" id="venue" placeholder="Enter venue name">
    
                                        @error('venue')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Take Attendance <i class="ri-login-box-line align-middle"></i></button>
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

    <script>
        function checkForm() { 
            $value =  $('#method').val();

            $('#by-file').fadeOut(100);
            
            if ($value === 'file'){
                $('#by-file').removeClass('d-none');
                $('#by-file').fadeIn(500);
            } else {
                console.log('Wrong choice');
            }
        }

        $(function () {
            checkForm();
        });
       
    </script>
@endpush

@push('link')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
