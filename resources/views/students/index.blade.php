@extends('layouts.app')

@push('title')
    View List of Students
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
                        <th>Reg #</th>
                        <th>Name</th>
                        <th>Programme</th>
                        {{-- <th># Students</th> --}}
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($students as $key => $student)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $student->username }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->programme->name }}</td>
                                <td class="text-center">
                                    @if ($student->deleted_at)
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($student->deleted_at)
                                        <a href="javascript:void(0)" onclick="$('{{ $student->slug }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class="ri-user-received-line"></i></a>
                                    @else
                                        <a href="{{ route('student.enroll', $student->slug) }}#" class="btn btn-primary waves-effect waves-light btn-sm"><i class=" ri-fingerprint-line"></i></a>
                                        <a href="{{-- {{ route('colleges.edit', $student->slug) }} --}}#" class="btn btn-warning waves-effect waves-light btn-sm"><i class="ri-edit-line"></i></a>
                                        <a href="javascript:void(0)" onclick="$('{{ $student->slug }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>

                                    @endif
                                    <form id="{{ $student->slug }}" action="{{-- {{ route('colleges.destroy', $student->slug) }} --}}" method="post">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    {{-- {{ $students->links() }} --}}
                </div>
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
