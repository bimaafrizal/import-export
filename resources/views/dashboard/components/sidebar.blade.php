  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">


          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                  href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
          @can('super-admin')
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('management-admin.*') ? '' : 'collapsed' }}"
                      href="{{ route('management-admin.index') }}">
                      <i class="bi bi-person-fill-gear"></i>
                      <span>Management Admin</span>
                  </a>
              </li>
          @endcan
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('landing-page-settings.*') ? '' : 'collapsed' }}"
                  data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>Setting Landing page</span><i
                      class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav"
                  class="nav-content collapse {{ request()->routeIs('landing-page-settings.index') ? 'show' : '' }}"
                  data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('landing-page-settings.index') }}"
                          class="{{ request()->routeIs('landing-page-settings.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Home</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.about-us') }}"
                          class="{{ request()->routeIs('landing-page-settings.about-us') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>About Us</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.product.index') }}"
                          class=" {{ request()->routeIs('landing-page-settings.product.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Product</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.gallery.index') }}"
                          class="{{ request()->routeIs('landing-page-settings.gallery.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Gallery</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.team.index') }}"
                          class="{{ request()->routeIs('landing-page-settings.team.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Team</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('landing-page-settings.contact.index') }}"
                          class="{{ request()->routeIs('landing-page-settings.contact.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Contact</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Components Nav -->
          @can('super-admin')
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('blog-categories.*') ? '' : 'collapsed' }}"
                      href="{{ route('blog-categories.index') }}">
                      <i class="bi bi-tag-fill"></i>
                      <span>Kategori Blog</span>
                  </a>
              </li>
          @endcan
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('blogs.*') ? '' : 'collapsed' }}"
                  href="{{ route('blogs.index') }}">
                  <i class="bi bi-newspaper"></i>
                  <span>Blog</span>
              </a>
          </li>

      </ul>

  </aside><!-- End Sidebar-->
