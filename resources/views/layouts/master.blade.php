<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('layouts.head')

  <style>

    .filter {
        font-size: 17px ;
        font-weight: 600 ;
    }

    table {
        max-width: 100% ;
     }
     .validé  td {
    background-color: rgba(200, 230, 201,0.8);
}

table {
        border-collapse: collapse;
        width: 100%;
        font-size: 0.95em;
        min-width: 400px;
    }

    th, td {
        text-align: center;
        padding: 12px;
        vertical-align: middle;
    }

    th {
        background-color: #343a40;
        color: #fff;
        font-weight: 700;
    }

    td {
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }

    /* Style pour les icônes d'état */
    .fa-check-circle, .fa-exclamation-circle, .fa-times-circle, .fa-clock {
        font-size: 20px;
    }

    .text-success {
        color: #28a745;
    }

    .text-info {
        color: #17a2b8;
    }

    .text-danger {
        color: #dc3545;
    }

    .text-warning {
        color: #ffc107;
    }

    /* Style pour les boutons d'action */
    .btn {
        padding: 9px 14px;
        font-size: 14px;
        border-radius: 2px;
        border-radius: 10px  ;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    .tablebilan td, .tablebilan th {
        padding: 5px;
        font-size: 14px;
    }


    .card-title {
    font-size: 18px;
  }

  .table th,
  .table td {
    padding: 0.5rem;
    vertical-align: middle;
  }

  .btn.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 12px;
  }

  .modal-title {
    font-size: 18px;
  }

  .modal-body .form-control {
    font-size: 14px;
    height: auto;
    padding: 0.375rem 0.75rem;
  }

  .modal-footer .btn {
    font-size: 12px;
  }
  .table-responsive {
  overflow-x: auto;
}
.square-img {
    width : 130px ;
    height: auto ;
}
.card-body {
    padding: 30px ;
}
.card {
    padding: 0 ;
}
.notification-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
}




  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('layouts.main-headerbar')

  @include('layouts.main-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            @yield('titre')
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">@yield('title_page')</a></li>
              <li class="breadcrumb-item active">@yield('title_page2')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @yield('content2')
  </div>
  @include('layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.footer-scripts')

</body>
</html>
