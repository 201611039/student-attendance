@extends('layouts.app')

@push('title')
    Verify
@endpush

@section('content')
        
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- <div class="alert alert-info" role="alert">
                    <strong><i class="text-danger ri-spam-2-line" style="font-size: 30px;"></i></strong>
                    <p>Place your fingerprint</p>
                </div> --}}

                <div id="result" class="alert alert-info" role="alert"></div>
                
                <form>

                    <input hidden value="Enroll FTRAPI(Template)" class="btn btn-warning" id="EnrollBtnFTRAPI" disabled/>
                    <input type="checkbox" name="isoconv" hidden value="0" id="ConvIsoCheckBox">


                    <div class="form-group">
                        <button type="button" onclick="beginOperation('enroll', 'ftrapi', false)" class="btn btn-primary waves-effect waves-light w-md">Verify <i class="ri-fingerprint-2-line align-middle"></i></button>
                    </div>
                </form>
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