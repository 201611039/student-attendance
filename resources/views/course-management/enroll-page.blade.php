@extends('layouts.app')

@push('title')
    Enroll Students
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
                        
                        <form action="{{ route('enroll.students.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select data-placeholder="Select Course" name="course" class="form-control @error('course') is-invalid @enderror">
                                            <option value="{{ null }}">Choose course</option>
                                            @foreach ($lectureCourses as $lectureCourse)
                                                <option value="{{$lectureCourse->course->id}}">{{ $lectureCourse->course->name }} - {{ $lectureCourse->course->code }}</option>
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
                                        <label class="control-label">Method</label>
                                        <select id="method" onchange="checkForm()" data-placeholder="Select method of enrollement" name="method" class="form-control @error('method') is-invalid @enderror">
                                            <option value="{{ null }}">Choose method</option>
                                            <option value="programme">By Programme</option>
                                            <option value="students">By Student</option>
                                            <option value="file">By File</option>
                                        </select>
    
                                        @error('method')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 by-programme d-none">
                                    <div class="form-group">
                                        <label class="control-label">Programmes</label>
                                        <select data-placeholder="Select programme" name="programme_id" class="form-control @error('programme_id') is-invalid @enderror">
                                            <option value="{{ null }}">Choose Programme</option>
                                            @foreach ($programmes as $programme)
                                                <option value="{{ $programme->id }}">{{ $programme->award->name }} in {{ $programme->name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('programme_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 by-programme d-none">
                                    <div class="form-group">
                                        <label class="control-label">Class Level</label>
                                        <select data-placeholder="Choose class level " name="level" class="form-control @error('level') is-invalid @enderror">
                                            <option value="{{ null }}">Choose Class Level</option>
                                            <option value="{{ 1 }}">First Year</option>
                                            <option value="{{ 2 }}">Second Year</option>
                                            <option value="{{ 3 }}">Third Year</option>
                                            <option value="{{ 4 }}">Fourth Year</option>
                                        </select>
    
                                        @error('level')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 d-none" id="by-students">
                                    <div class="form-group">
                                        <label class="control-label">Students</label>
                                        <select style="width: 100% !important;" data-placeholder="Choose students" name="students[]" class="form-control select2 @error('students') is-invalid @enderror" multiple>
                                            <option value="{{ null }}">Choose Students</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('students')
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
                                            <input type="file" name="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Enrole <i class="ri-login-box-line align-middle"></i></button>
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

            $('.by-programme').fadeOut(100);
            $('#by-students').fadeOut(100);
            $('#by-file').fadeOut(100);
            
            if ($value === 'programme') {
                $('.by-programme').removeClass('d-none');
                $('.by-programme').fadeIn(500);
            } else if ($value === 'students'){
                $('#by-students').removeClass('d-none');
                $('#by-students').fadeIn(500);
            } else if ($value === 'file'){
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
