@extends('layouts.master')


@section('title')
Modifier prix_location
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



@section('content2').

@if(session('success'))
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
                    <h3 class="card-title">Modifier prix_location Annees</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('annees.update', $annee->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="annee">Année (AAAA)</label>
                            <input type="number" class="form-control" id="annee" name="annee" placeholder="Entrez l'année" value="{{ $annee->annee }}">
                            <script>
                                document.querySelector("input[type=number]")
                                    .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
                            </script>

                        </div>
                        <div class="form-group">
                            <label for="prix_location">prix_location (DH)</label>
                            <input type="text" class="form-control" id="prix_location" name="prix_location" placeholder="Entrez le prix_location" value="{{ $annee->prix_location }}">
                        </div>
                    </div>

                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Modifier</button>
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
$(function () {
  bsCustomFileInput.init();
});
</script>

@endsection
