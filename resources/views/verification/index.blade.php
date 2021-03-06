@extends('layouts.app')

@push('title')
    View Exam Session List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th># Students</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($exams as $key => $exam)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                {{-- <td>
                                    @foreach ($exam->examCourses as $course)
                                        <span class="badge badge-primary">{{ $course->code }}</span>
                                    @endforeach
                                </td> --}}
                                <td>{{ $exam->name }}</td>
                                <td>{{ $exam->sit_date->format('d-m-y, H:i') }}</td>
                                <td>{{ $exam->venue }}</td>
                                <td>{{ 0 }}</td>
                                <td class="text-center">
                                    @if ($exam->status)
                                        <span class="badge badge-pill badge-danger">Closed</span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Open</span>
                                    @endif
                                </td>
                                <td></td>
                                <td class="text-center">
                                    @if ($exam->deleted_at)
                                        <a href="javascript:void(0)" onclick="$('#{{ $exam->slug }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class="ri-user-received-line align-middle"></i></a>
                                    @else
                                        <a href="{{ route('exam.verification.fingerprint', $exam->slug) }}" class="btn btn-primary waves-effect waves-light btn-sm"><i class="ri-eye-line align-middle"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#{{ $exam->slug }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line align-middle"></i></a>

                                    @endif
                                    {{-- <form id="{{ $exam->slug }}" action="{{ route('users.destroy', $exam->slug) }}" method="post">@csrf @method('DELETE')</form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection


@push('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        // $('#datatable').DataTable();
    </script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endpush

@push('link')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
