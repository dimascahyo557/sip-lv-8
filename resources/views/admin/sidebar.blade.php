<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ url('/admin') }}" class="nav-link @if(Request::is('admin')) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link @if(Request::is('admin/category*') || Request::is('admin/product*')) active @endif">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
              Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/category') }}" class="nav-link @if(Request::is('admin/category*')) active @endif">
                <i class="fas fa-book nav-icon"></i>
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link @if(Request::is('admin/product*')) active @endif">
                <i class="fas fa-list nav-icon"></i>
                <p>Product</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('transaction.index') }}" class="nav-link @if(Request::is('admin/transaction*')) active @endif">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
              Sales
            </p>
          </a>
        </li>
        <li class="nav-item">
          {{ Form::open(['route' => 'logout', 'method' => 'post']) }}
          <button type="submit" class="nav-link">
            <i class="nav-icon fas fa-door-open"></i>
            <p>
              Logout
            </p>
          </button>
          {{ Form::close() }}
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>