@php
    $navigations = collect([
        [
            'title' => 'Dashboard', 'url' => route('dashboard'), 'permission' => true, 'icon' => 'ri-dashboard-line', 'childrens' => collect(),
        ], [
            'title' => 'Users Mgt', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('user-view', 'user-add', 'user-update', 'user-delete', 'user-activate', 'user-deactivate'), 'icon' => 'ri-group-line', 'childrens' => collect([
                [
                    'title' => 'List', 'url' => route('users.index'), 'permission' => request()->user()->hasAnyPermission('user-view')
                ], [
                    'title' => 'Add', 'url' => route('users.create'), 'permission' => request()->user()->hasAnyPermission('user-add')
                ], [
                    'title' => 'Roles', 'url' => route('roles.index'), 'permission' => request()->user()->hasAnyPermission('role-view')
                ], [
                    'title' => 'Fingerprint', 'url' => route('roles.index'), 'permission' => request()->user()->hasAnyPermission('role-view')
                ]
            ]),

        ], [
            'title' => 'Setting', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('user-view', 'user-add', 'user-update', 'user-delete', 'user-activate', 'user-deactivate'), 'icon' => 'ri-folder-settings-line', 'childrens' => collect([
                [
                    'title' => 'College', 'url' => route('college.index'), 'permission' => request()->user()->hasAnyPermission('college-view')
                ], [
                    'title' => 'Department', 'url' => route('department.index'), 'permission' => request()->user()->hasAnyPermission('department-view')
                ], [
                    'title' => 'Programme', 'url' => route('programme.index'), 'permission' => request()->user()->hasAnyPermission('programme-view')
                ]
            ]),
        ], [
            'title' => 'Course Management', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('course-management-view', 'course-management-enroll'), 'icon' => 'ri-book-3-line', 'childrens' => collect([
                [
                    'title' => 'List', 'url' => route('view.courses'), 'permission' => request()->user()->hasAnyPermission('course-management-view')
                ], [
                    'title' => 'Enroll', 'url' => route('enroll.students'), 'permission' => request()->user()->hasAnyPermission('course-management-enroll')
                ], [
                    'title' => 'Allocate', 'url' => route('allocate.lecturers'), 'permission' => request()->user()->hasAnyPermission('course-management-allocate')
                ]
            ]),
        ], [
            'title' => 'Student Management', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('student-view', 'student-fingerprint-enroll'), 'icon' => ' ri-user-settings-line', 'childrens' => collect([
                [
                    'title' => 'List', 'url' => route('student.list'), 'permission' => request()->user()->hasAnyPermission('student-view')
                ], [
                    'title' => 'Enroll Fingerprint', 'url' => route('student.enroll'), 'permission' => request()->user()->hasAnyPermission('student-fingerprint-enroll')
                ]
            ]),
        ], [
            'title' => 'Attendance', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('attendance-take-class'), 'icon' => 'ri-contacts-line ', 'childrens' => collect([
                [
                    'title' => 'View Attendance', 'url' => route('attendance.list'), 'permission' => request()->user()->hasAnyPermission('attendance-take-class')
                ], [
                    'title' => 'Take Class Attendance', 'url' => route('attendance.class'), 'permission' => request()->user()->hasAnyPermission('attendance-take-class')
                ]
            ]),
        ], [
            'title' => 'Verification', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('attendance-take-exam'), 'icon' => 'ri-shield-user-line ', 'childrens' => collect([
                [
                    'title' => 'View Exam Verifications', 'url' => route('exam.list'), 'permission' => request()->user()->hasAnyPermission('attendance-take-class')
                ], [
                    'title' => 'Exam Verification', 'url' => route('verification.exam'), 'permission' => request()->user()->hasAnyPermission('attendance-take-exam')
                ]
            ]),
        ]
    ]);
@endphp

<div class="vertical-menu">

  <div data-simplebar class="h-100">

      <!--- Sidemenu -->
      <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
              <li class="menu-title">Menu</li>

              @foreach ($navigations as $navigation)
                @if($navigation['permission'] || auth()->user()->hasRole('super-admin'))
                <li>
                    <a href="{{ $navigation['url'] }}" class="{{ ($navigation['childrens']->count()) ? 'has-arrow':'' }} waves-effect">
                        <i class="{{ $navigation['icon'] }}"></i>
                        <span>{{ $navigation['title'] }}</span>
                    </a>
                    @if ($navigation['childrens'])
                        <ul class="sub-menu" aria-expanded="true">
                            @foreach ($navigation['childrens'] as $navChild1)
                                @if($navChild1['permission'] || auth()->user()->hasRole('super-admin'))
                                <li><a href="{{ $navChild1['url'] }}" class="{{ ($navChild1['childrens']??false) ? 'has-arrow':'' }}">{{ $navChild1['title'] }}</a>
                                    @if ($navChild1['children']??false)
                                        <ul class="sub-menu" aria-expanded="true">
                                            @foreach ($navChild1['children'] as $child)
                                                @if($child['permission'] || auth()->user()->hasRole('super-admin'))
                                                <li><a href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                                @endif
                                
                            @endforeach
                        </ul>
                    @endif
                </li>
                @endif
                
              @endforeach

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
</div>
