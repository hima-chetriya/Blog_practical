<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
  <div>
    <div class="logo-wrapper"><a href="index.html">Blog Management System</a>

    </div>
    <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid" src="{{asset('backend/assets/images/logo/logo-icon.png')}}" alt=""></a></div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          <li class="back-btn"><a href="index.html"><img class="img-fluid" src="{{asset('backend/assets/images/logo/logo-icon.png')}}" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>

          @php
          $dashboard_style = '';
          $dashboard_arr = ['dashboard'];
          $current_route = Route::current()->getName();
          if (in_array($current_route, $dashboard_arr)) {
          $dashboard_style = 'active';
          }
          @endphp

          <li class="sidebar-list"><i class=""></i>
            <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title {{ $dashboard_style }}" href="{{route('dashboard')}}">
              <svg class="stroke-icon">
                <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
              </svg>
              </svg><span class="">Dashboard</span></a>
          </li>

          
          @php
          $category_style = '';
          $category_arr = ['categories.index','categories.create','categories.edit','categories.show'];
          $current_route = Route::current()->getName();
          if (in_array($current_route, $category_arr)) {
          $category_style = 'active';
          }
          @endphp

          <li class="sidebar-list"><i class=""></i>
            <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title {{ $category_style }}" href="{{ route('categories.index') }}">
              <svg class="stroke-icon">
                <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
              </svg>
              </svg><span class="">Categories</span></a>
          </li>



          @php
          $posts_style = '';
          $posts_arr = ['posts.index','posts.create','posts.edit','posts.show'];
          $current_route = Route::current()->getName();
          if (in_array($current_route, $posts_arr)) {
          $posts_style = 'active';
          }
          @endphp

          
          <li class="sidebar-list"><i class=""></i>
            <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title {{$posts_style}}" href="{{ route('posts.index') }}">
              <svg class="stroke-icon">
                <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
              </svg>
              </svg><span class="">Posts</span></a>
          </li>

      </div>

    </nav>
  </div>
</div>