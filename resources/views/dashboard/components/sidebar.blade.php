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
              <a class="nav-link {{ request()->routeIs('landing-page-settings.*') ? '' : 'collapsed' }}" href="{{ route('landing-page-settings.index') }}">
                  <i class="bi bi-archive"></i>
                  <span>Setting Landing page</span>
              </a>
          </li>
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
          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>Components</span><i
                      class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="components-alerts.html">
                          <i class="bi bi-circle"></i><span>Alerts</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-accordion.html">
                          <i class="bi bi-circle"></i><span>Accordion</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-badges.html">
                          <i class="bi bi-circle"></i><span>Badges</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-breadcrumbs.html">
                          <i class="bi bi-circle"></i><span>Breadcrumbs</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-buttons.html">
                          <i class="bi bi-circle"></i><span>Buttons</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-cards.html">
                          <i class="bi bi-circle"></i><span>Cards</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-carousel.html">
                          <i class="bi bi-circle"></i><span>Carousel</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-list-group.html">
                          <i class="bi bi-circle"></i><span>List group</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-modal.html">
                          <i class="bi bi-circle"></i><span>Modal</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-tabs.html">
                          <i class="bi bi-circle"></i><span>Tabs</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-pagination.html">
                          <i class="bi bi-circle"></i><span>Pagination</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-progress.html">
                          <i class="bi bi-circle"></i><span>Progress</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-spinners.html">
                          <i class="bi bi-circle"></i><span>Spinners</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-tooltips.html">
                          <i class="bi bi-circle"></i><span>Tooltips</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Components Nav -->
      </ul>

  </aside><!-- End Sidebar-->
