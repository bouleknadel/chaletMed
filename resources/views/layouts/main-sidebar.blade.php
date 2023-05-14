<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/img/admin2.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ auth()->user()->name }}  {{ auth()->user()->lastname }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- SidebarSearch Form -->
      <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class

            with font-awesome or any other icon font library -->
            <li class="nav-item">
  <a href="{{ route('dashboard') }}" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p class="ml-2" >Dashboard</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('users.index') }}" class="nav-link">
    <i class="fas fa-users"></i>
    <p class="ml-2">Liste des utilisateurs</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('cotisations.index') }}" class="nav-link">
    <i class="fas fa-money-bill"></i>
    <p class="ml-2">Cotisations</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('charges.index') }}" class="nav-link">
    <i class="fas fa-file-invoice-dollar"></i>
    <p class="ml-2">Charges</p>
  </a>
</li>
<li class="nav-item">
    <a href="{{ route('cotisations.recouvrement') }}" class="nav-link">
        <i class="fas fa-file-invoice-dollar"></i>
        <p class="ml-2">Synthese recouvrement
        </p>
      </a>
</li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
            Forms
                <i class="fas fa-angle-left right "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link">
                 <i class="fas fa-user-plus"></i>
                  <p class="ml-2">Ajouter utilsateur</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="{{ route('cotisations.create') }}"  class="nav-link">
                    <i class="fas fa-plus"></i>
                  <p class="ml-2">Ajouter cotisation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('charges.create') }}" class="nav-link">
                    <i class="fas fa-plus"></i>
                  <p class="ml-2">Ajouter charge</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-cog"></i>
              <p class="ml-2">
                parametres
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('annees.create') }}" class="nav-link">
                    <i class="fas fa-plus"></i>
                  <p class="ml-2">Ajouter une montant</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('annees.index') }}" class="nav-link">
                    <i class="fas fa-list"></i>
                  <p class="ml-2">Listes des montants</p>
                </a>
              </li>
            </ul>
          </li>
          <!--=================================Exemples========================================-->

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
