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
                @if($navigation['permission'])
                <li>
                    <a href="{{ $navigation['url'] }}" class="{{ ($navigation['childrens']->count()) ? 'has-arrow':'' }} waves-effect">
                        <i class="{{ $navigation['icon'] }}"></i>
                        <span>{{ $navigation['title'] }}</span>
                    </a>
                    @if ($navigation['childrens'])
                        <ul class="sub-menu" aria-expanded="true">
                            @foreach ($navigation['childrens'] as $navChild1)
                                @if($navChild1['permission'])
                                <li><a href="{{ $navChild1['url'] }}" class="{{ ($navChild1['childrens']??false) ? 'has-arrow':'' }}">{{ $navChild1['title'] }}</a>
                                    @if ($navChild1['children']??false)
                                        <ul class="sub-menu" aria-expanded="true">
                                            @foreach ($navChild1['children'] as $child)
                                                @if($child['permission'])
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
