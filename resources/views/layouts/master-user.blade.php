<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('layouts.head')

  <style>
    th {
        background: rgb(197, 224, 233) ;
    }
    .card-head{
        margin: 30px 20px ;

    }
    .card-head .card-title{
        font-size: 30px ;
        font-weight: 400 ;
    }
   .table {
  border-collapse: collapse;
}

.table td,
.table th {
  border: none;
  border-bottom: 1px solid #ddd;
  border-right: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('layouts.main-user-headerbar')

  @include('layouts.main-user-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
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
