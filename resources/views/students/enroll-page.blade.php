@extends('layouts.app')

@push('title')
    Enroll Student Fingerprint
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
                        
                        <div id="result" class="alert alert-info" role="alert">

                        </div>

                        <form>
                            @csrf

                            <div class="row">
                                <div class="col-sm-12" id="by-students">
                                    <div class="form-group">
                                        <label class="control-label">Students</label>
                                        <select style="width: 100% !important;" data-placeholder="Choose student" name="students" class="form-control select2 @error('student') is-invalid @enderror">
                                            <option value="{{ null }}">Choose Students</option>
                                            @foreach ($students as $s)
                                                <option {{ $student? ($student->slug == $s->slug?'selected':''):('') }} value="{{ $s->id }}">{{ $s->username }} - {{ $s->full_name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('student')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div id="image">
                                    <canvas id="fingerframe" height="480" width="320"></canvas>
                                </div> --}}

                                <input hidden value="Enroll FTRAPI(Template)" class="btn btn-warning" id="EnrollBtnFTRAPI" disabled/>
                                <input type="checkbox" name="isoconv" hidden value="0" id="ConvIsoCheckBox">

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="button" onclick="beginOperation('enroll', 'ftrapi', true)" class="btn btn-primary waves-effect waves-light w-md">Enrole <i class="ri-fingerprint-2-line align-middle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="resultLinks">
                            <a id="resultLink" href="http://www.futronic-tech.com" rel="external" media="application/octet-stream">
                            www.futronic-tech.com
                            </a>
                        </div>
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
    <script src="{{ asset('assets/js/furtonic-main.js') }}" defer></script>

    <script>
        $(document).ready(function () {
            onBodyLoad();
        });
    </script>
@endpush

@push('link')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
