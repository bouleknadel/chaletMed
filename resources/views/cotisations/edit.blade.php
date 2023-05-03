@extends('layouts.master')


@section('title')
Modifier cotisation
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
    <div class="alert alert-info text-white" style="background-color: #17a2b8;">
        <i class="fas fa-edit"></i> {{ session('success') }}
    </div>
@endif


<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-9 m-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Modifier la cotisation</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('cotisations.update', $cotisation->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Utilisateur</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $cotisation->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant</label>
                            <input type="number" name="montant" id="montant" class="form-control" value="{{ $cotisation->montant }}" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $cotisation->date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="recu_paiement">Reçu de paiement</label>
                            <input type="file" name="recu_paiement" id="recu_paiement" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="non payé" {{ $cotisation->status == 'non payé' ? 'selected' : '' }}>Non payé</option>
                                <option value="payé" {{ $cotisation->status == 'payé' ? 'selected' : '' }}>Payé</option>
                            </select>
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
