<nav class="sidebar-wrapper">

    <!-- Sidebar brand starts -->
    <div class="sidebar-bran">
      <a href="{{ route('dashboard') }}" class="loogoo">
        <img src="{{ asset('assets/images/stock.jpg') }}" alt="Admin Dashboards">
      </a>
    </div>
    <!-- Sidebar brand starts -->

    <!-- Sidebar menu starts -->
    <div class="sidebar-menu">
      <div class="sidebarMenuScroll">
        <ul>
         
          <li class="sidebar-dropdown {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="#">
                <i class="bi bi-house"></i>
                <span class="menu-text">Dashboards</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'current-page' : '' }}">Analytics</a>
                    </li>
                  
                </ul>
            </div>
          </li>

          @can('ges_utilisateurs')
            <li class="sidebar-dropdown {{ request()->routeIs('User.*') ? 'active' : '' }}">
              <a href="#">
                  <i class="bi bi-person"></i>
                  <span class="menu-text">Utilisateurs</span>
              </a>
              <div class="sidebar-submenu">
                  <ul>
                    @can('manage-users')
                      <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                          <a href="{{ route('users.index') }}">
                              <i class="bi bi-people"></i>
                              <span class="menu-text">Utilisateurs</span>
                          </a>
                      </li>
                    @endcan

                      {{-- <li>
                          <a href="{{ route('users.index') }}"
                            class="{{ request()->routeIs('users.index') ? 'current-page' : '' }}">Listes utilisateurs</a>
                      </li> --}}
                      <li>
                        <a href="{{ route('users.index') }}"
                          class="{{ request()->routeIs('users.index') ? 'current-page' : '' }}">Listes Utilisateur</a>
                      </li>
                      <li>
                          <a href="{{ route('register') }}"
                            class="{{ request()->routeIs('register') ? 'current-page' : '' }}">Ajouter Utilisateur</a>
                      </li>
                      <li>
                          <a href="{{ route('roles.index') }}"
                            class="{{ request()->routeIs('roles.index') ? 'current-page' : '' }}">Roles</a>
                      </li>
                      <li>
                          <a href="{{ route('permissions.index') }}"
                            class="{{ request()->routeIs('permissions.index') ? 'current-page' : '' }}">Permissions</a>
                      </li>
                  </ul>
              </div>
            </li>
          @endcan

          <li class="sidebar-dropdown {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <a href="#">
                <i class="bi bi-ui-checks-grid"></i>
                <span class="menu-text">Catégories</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{ route('categories.index') }}"
                           class="{{ request()->routeIs('categories.index') ? 'current-page' : '' }}">Gérer Catégories</a>
                    </li>
                   
                </ul>
            </div>
          </li>

          <li class="sidebar-dropdown {{ request()->routeIs('outil.*') ? 'active' : '' }}">
            <a href="#">
                <i class="bi bi-wrench"></i>
                <span class="menu-text">Outils</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{ route('outil.index') }}"
                           class="{{ request()->routeIs('outil.index') ? 'current-page' : '' }}">Tous les outils</a>
                    </li>
                    <li>
                        <a href="{{ route('outil.create') }}"
                           class="{{ request()->routeIs('outil.create') ? 'current-page' : '' }}">Ajouter Outil</a>
                    </li>
                </ul>
            </div>
          </li>


          
          <li class="sidebar-dropdown {{ request()->routeIs('ventes.*') ? 'active' : '' }}">
            <a href="#">
                <i class="bi bi-cart"></i>
                <span class="menu-text">Ventes</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{ route('ventes.index') }}"
                           class="{{ request()->routeIs('ventes.index') ? 'current-page' : '' }}">Tous les ventes</a>
                    </li>
                    <li>
                        <a href="{{ route('ventes.create') }}"
                           class="{{ request()->routeIs('ventes.create') ? 'current-page' : '' }}">Ajouter Vente</a>
                    </li>
                </ul>
            </div>
          </li>

          @can('ges_utilisateurs')
            <li class="sidebar-dropdown {{ request()->routeIs('login.*') ? 'active' : '' }}">
              <a href="#">
                  <i class="bi bi-handbag"></i>
                  <span class="menu-text">Authentification</span>
              </a>
              <div class="sidebar-submenu">
                  <ul>
                      <li>
                          <a href="{{ route('login') }}"
                            class="{{ request()->routeIs('login') ? 'current-page' : '' }}">Login</a>
                      </li>
                      {{-- <li>
                          <a href="{{ route('password.request') }}"
                            class="{{ request()->routeIs('password.request') ? 'current-page' : '' }}">Mot de passe Oublié</a>
                      </li> --}}
                      {{-- <li>
                        <a href="{{ route('password.reset') }}"
                          class="{{ request()->routeIs('password.reset') ? 'current-page' : '' }}">Réinitialiser Mot de passe</a>
                      </li> --}}
                  </ul>
              </div>
            </li>
          @endcan
  
        </ul>
      </div>
    </div>
    <!-- Sidebar menu ends -->

  </nav>  
  