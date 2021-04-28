@section('header-admin')
<div class="d-flex">
    <div class="vertical-nav bg-white" id="sidebar">
      <div class="py-4 px-3 mb-1">
        <div class="media d-flex align-items-center">
          <div class="profile-img">
            <!-- <a href="{{ ((Auth::user()->img) && ($userimg)) ? ($userimg) : '/img/svg/laptop-house-solid.svg' }}" class="rounded-circle img-thumbnail shadow-sm"></a> -->
            <a href="{{ ((Auth::user()->img) && ($userimg)) ? ($userimg) : '/img/svg/laptop-house-solid.svg' }}" data-fancybox="gallery-1"><img src="{{ ((Auth::user()->img) && ($userimg)) ? ($userimg) : '/img/svg/laptop-house-solid.svg' }}" class="rounded-circle img-thumbnail shadow-sm"></a>
            <form action="{{ route('user_edit') }}" class="user_edit_form" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="file btn btn-lg btn-primary">
                  <label for="userimg" class="changeimg">Change</span>
                  <input type="file" id="userimg" name="userimg">
              </div>
          </form>
          </div>
          <div class="media-body">
            <h4 class="m-0 text-center">{{ Auth::user()->name }}</h4>
            <p class="font-weight-light text-muted mb-0 text-center">{{ Auth::user()->Users_Role}}</p>
          </div>
          <div>
            <button id="sidebarCollapseMedia" type="button" class="btn m-0 mt-3 mb-auto"><div class="animated-icon2 sidebarNav open"><span></span><span></span><span></span><span></span></div></button>
          </div>
        </div>
      </div>

      <p class="text-gray font-weight-bold text-uppercase px-3 pb-4 mb-0">Main</p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <a href="{{ route('index') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic">
                    <i class="fa fa-th-large mr-1 text-primary fa-fw"></i>
                    Main
                </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('paydel') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic">
                    <i class="fa fa-address-card mr-1 text-primary fa-fw"></i>
                    Payment and delivery
                </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('contacts') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic">
                    <i class="fa fa-cubes mr-1 text-primary fa-fw"></i>
                    Contacts
                </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('aboutus') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic">
                    <i class="fa fa-picture-o mr-1 text-primary fa-fw"></i>
                    About us
                </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 py-4 mb-0">Charts</p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <a href="{{ route('user_panel') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic {{ Request::is('user-panel') ? 'activeNavItem' : NULL }}">
                    <i class="fa fa-area-chart mr-1 text-primary fa-fw"></i>
                    Personal area
                </a>
        </li>
        @if(Auth::user()->role)
        <li class="nav-item">
          <a href="{{ route('admin_order') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic {{ Request::is('admin/admin-order') ? 'activeNavItem' : NULL }}">
                    <i class="fa fa-bar-chart mr-1 text-primary fa-fw"></i>
                    Orders
                </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('categories.index') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic {{ Request::is('admin/categories') ? 'activeNavItem' : NULL }}">
                    <i class="fa fa-pie-chart mr-1 text-primary fa-fw"></i>
                    Categories
                </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('products.index') }}" class="hoverNavItem nav-fonts nav-link text-dark font-italic {{ Request::is('admin/products') ? 'activeNavItem' : NULL }}">
                    <i class="fa fa-line-chart mr-1 text-primary fa-fw"></i>
                    Products
                </a>
        </li>
        @endif
        <li class="nav-item">
          <a id="logout-link" href="#" class="hoverNavItem nav-fonts nav-link text-dark font-italic">
              <i class="fa fa-area-chart mr-1 text-primary fa-fw"></i>
              Log out
          </a>
          <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
          </form>
        </li>
        <!-- @if(Auth::user()->role === 2)
        <li class="nav-item mb-3">
          <a href="#" class="hoverNavItem nav-fonts nav-link text-dark font-italic {{ Request::is('edit-users') ? 'activeNavItem' : NULL }}">
                    <i class="fa fa-line-chart mr-1 text-primary fa-fw"></i>
                    Пользователи
                </a>
        </li>
        @endif -->
      </ul>
    </div>
</div>
