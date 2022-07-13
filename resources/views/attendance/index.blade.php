@extends('layouts.app')

@push('title')
    View Attendance List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('attendance.list') }}" method="get">
            <div class="row mb-2">
                <div class="form-group col-4">
                    <select data-placeholder="Select Course" name="course_id" class="form-control @error('course_id') is-invalid @enderror">
                        <option value="{{ null }}">Choose course</option>
                        @foreach ($lectureCourses as $lectureCourse)
                            <option value="{{$lectureCourse->course->slug}}" {{ $lectureCourse->course->slug === $course_id? 'selected':''}}>{{ $lectureCourse->course->name }} - {{ $lectureCourse->course->code }}</option>
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
        </form>
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Day & Venue</th>
                        <th>Date</th>
                        <th class="text-center"># of Attended Student</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($periods as $key => $period)
                       
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td>
                                <span class="btn btn-primary">
                                    {{ \Carbon\Carbon::parse($key)->format('l') }}
                                    <div class="clearfix"></div>
                                    <strong>Venue:</strong> {{ $period->first()->venue }}
                                </span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($key)->format('d-m-Y H:i') }}
                            </td>
                            <td class="text-center">{{ $period->count() }}</td>
                            <td class="text-center"><a href="{{ route('attendance.details', [$key, $course_id]) }}" class="btn btn-sm btn-warning">Details</a></td>
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
