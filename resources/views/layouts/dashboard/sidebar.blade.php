<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item sidebar-category">
        <p>Navigation</p>
        <span></span>
      </li>
      <li class="nav-item {{set_active( ['home',''] )}}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="mdi mdi-view-quilt menu-icon"></i>
          <span class="menu-title">Dashboard</span>
          <div class="badge badge-info badge-pill">2</div>
        </a>
      </li>
      <li class="nav-item sidebar-category">
        <p>Master</p>
        <span></span>
      </li>
      {{-- jika role user adalah admin --}}
      @if (Auth::user()->role == '1')
      <li class="nav-item {{ set_active( ['merk','add-merk','edit-merk','product','add-product','edit-product'] )}}">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-palette menu-icon"></i>
          <span class="menu-title">Data Product</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('merk') }}">Merk</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('product') }}">Laptop</a></li>
          </ul>
        </div>
      </li>
      @endif
      
      <li class="nav-item {{ set_active( ['user','add-user','edit-user'] )}}">
        <a class="nav-link" href="{{ route('user') }}">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Data User</span>
        </a>
      </li>
      <li class="nav-item {{ set_active( ['pemesanan','detail'] )}}">
        <a class="nav-link" href="{{ route('pemesanan') }}">
          <i class="mdi mdi-cart menu-icon"></i>
          <span class="menu-title">Pemesanan</span>
        </a>
      </li>
      
      
     
    </ul>
  </nav>