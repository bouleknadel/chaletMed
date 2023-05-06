@extends('layouts.master')


@section('title')
Dashboard
@endsection



@section('css')

@endsection



@section('title_page')

@endsection


@section('title_page2')

@endsection



@section('content2')
 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $total_users }}</h3>

              <p>Nombre total d'utilisateurs</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $pourcentage_paye }}<sup style="font-size: 20px">%</sup> -
            {{ $chiffre_affaire_payé}} DH</h3>

              <p>Cotisations payées <span style="font-size: 11px">(année en cours)</span> </p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'paid']) }}" class="small-box-footer">More info  <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $pourcentage_non_paye }}<sup style="font-size: 20px">%</sup> -
            {{$chiffre_affaire_non_payé}} DH</h3>

              <p>Cotisations non payées <span style="font-size: 11px">(année en cours)</span></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'unpaid']) }}" class="small-box-footer">More info  <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $total_adherents }}</h3>

              <p>Nombre des adherents</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>

          </div>
        </div>
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $total_adherents }}</h3>

              <p>Nombre chalet occupé</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->

          <!-- /.card -->

          <!-- DIRECT CHAT -->

          <!--/.direct-chat -->

          <!-- TO DO List -->

          <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">


          <!-- /.card -->


          <!-- /.card -->


          <!-- /.card -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection


@section('scripts')

@endsection
