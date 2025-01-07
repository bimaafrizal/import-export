  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">


          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('management-admin.*') ? '' : 'collapsed' }}" href="{{ route('management-admin.index') }}">
                  <i class="bi bi-person-fill-gear"></i>
                  <span>Management Admin</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('landing-page-settings.*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>Setting Landing page</span><i
                      class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav" class="nav-content collapse {{ request()->routeIs('landing-page-settings.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('landing-page-settings.index') }}" class="{{ request()->routeIs('landing-page-settings.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Home</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.about-us') }}" class="{{ request()->routeIs('landing-page-settings.about-us') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>About Us</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Components Nav -->
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('kategori-blog.*') ? '' : 'collapsed' }}" href="{{ route('management-admin.index') }}">
                  <i class="bi bi-person-fill-gear"></i>
                  <span>Kategori Blog</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('blog.*') ? '' : 'collapsed' }}" href="{{ route('management-admin.index') }}">
                  <i class="bi bi-newspaper"></i>
                  <span>Blog</span>
              </a>
          </li>

      </ul>

  </aside><!-- End Sidebar-->
