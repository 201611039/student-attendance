@extends('layouts.app')

@push('title')
    View Attendance List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row mb-2">
            <div class="form-group col-4">
                <select data-placeholder="Select Course" name="course_id" class="form-control @error('course_id') is-invalid @enderror">
                    <option value="{{ null }}">Choose course</option>
                    @foreach ($lectureCourses as $lectureCourse)
                        <option value="{{$lectureCourse->course->id}}">{{ $lectureCourse->course->name }} - {{ $lectureCourse->course->code }}</option>
                    @endforeach
                </select>

                @error('course_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-4">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th># Students</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        {{-- @foreach ($courses as $key => $course)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $course->full_name }}</td>
                                <td>{{ $course->email }}</td>
                                <td>
                                    @foreach ($course->roles as $role)
                                       <span class="badge badge-primary">{{ title_case(str_replace('-', ' ', $role->name)) }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $course->phone }}</td>
                                <td class="text-center">
                                    @if ($course->deleted_at)
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($course->deleted_at)
                                        <a href="javascript:void(0)" onclick="$('#{{ $course->username }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class="ri-user-received-line"></i></a>
                                    @else
                                        <a href="{{ route('users.edit', $course->username) }}" class="btn btn-warning waves-effect waves-light btn-sm"><i class="ri-edit-line"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#{{ $course->username }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>

                                    @endif
                                    <form id="{{ $course->username }}" action="{{ route('users.destroy', $course->username) }}" method="post">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @endforeach --}}
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
