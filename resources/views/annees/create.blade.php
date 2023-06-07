@extends('layouts.master')


@section('title')
    cree prix_location
@endsection



@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
@endsection



@section('title_page')
@endsection


@section('title_page2')
@endsection



@section('content2')
    .

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>{{ session('success') }}
        </div>
    @endif


    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9 m-auto">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Montant de cotisation par annee</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('annees.store') }}">

                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="annee">Année</label>
                                <select name="annee" id="annee"
                                    class="form-control @error('annee')
                                    is-invalid
                                @enderror"
                                    required>
                                    @php
                                        $currentYear = date('Y');
                                        $nextYear = $currentYear + 1;
                                    @endphp
                                    @for ($year = 2018; $year < $currentYear; $year++)
                                        @php
                                            $yearRange = $year . '/' . ($year + 1);
                                        @endphp
                                        <option value="{{ $yearRange }}">{{ $yearRange }}</option>
                                    @endfor
                                    <option value="{{ $currentYear }}/{{ $nextYear }}" selected>
                                        {{ $currentYear }}/{{ $nextYear }}</option>
                                </select>
                                @error('annee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="prix_location">Montatn de cotisation (DH)</label>
                                <input type="text" class="form-control @error('prix_location') is-invalid @enderror"
                                    id="prix_location" name="prix_location" placeholder="Entrez le prix_location">
                                @error('prix_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
