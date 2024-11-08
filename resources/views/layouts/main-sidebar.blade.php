<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <?php if (auth()->user()->role === 'admin' || auth()->check()): ?>
        <img src="{{ asset('assets/img/admin logo.png') }}" alt="Admin Logo" class="brand-image rounded-circle elevation-3"
            style="opacity: .8">
        <?php elseif (auth()->user()->role === 'syndic'): ?>
        <img src="{{ asset('assets/img/syndic logo.png') }}" alt="Syndic Logo"
            class="brand-image rounded-circle elevation-3" style="opacity: .8">
        <?php endif; ?>
        <span class="brand-text font-weight-light">{{ auth()->user()->name }} {{ auth()->user()->lastname }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>Liste des utilisateurs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cotisations.index') }}" class="nav-link">
                        <i class="fas fa-money-bill"></i>
                        <p>Cotisations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('charges.index') }}" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p> Charges</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cotisations.recouvrement') }}" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Synthèse recouvrement</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bilan.calculate') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <p>Bilan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('releve_bnks.index') }}" class="nav-link">
                        <i class="fas fa-file"></i>
                        <p>Relevé bancaire</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('document_divers.index') }}" class="nav-link">
                        <i class="fas fa-file"></i>
                        <p>Document divers</p>
                    </a>
                </li>
                @if (Auth::user()->role != 'syndic')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <p>Paramètres<i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('balances.index') }}" class="nav-link">
                                    <i class="fas fa-file"></i>
                                    <p>Balances</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('annees.index') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Montant de cotisation</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('parametre.bureau') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Ajouter membre bureau</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('parametre.listeMembres') }}" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>liste des Membres</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('annees.index') }}" class="nav-link">
                                    <i class="fas fa-list"></i>
                                    <p>Liste des montants</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('parametre.autre') }}" class="nav-link">
                                    <i class="fas fa-coins"></i>
                                    <p>Autre</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>
