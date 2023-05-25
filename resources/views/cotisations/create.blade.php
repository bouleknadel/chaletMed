@extends('layouts.master')


@section('title')
cree cotisation
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

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle alert-icon"></i>{{ session('error') }}
    </div>
@endif


<div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-9 m-auto">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="POST" action="{{ route('cotisations.store') }}" enctype="multipart/form-data">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="user_id">Utilisateur</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach($users as $user)
                            @if($user->role == 'user')
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
    <div class="form-group">
        <label for="montant">Montant <span style="font-size: 14px ; "> (en DH)</span></label>
        <input type="number" name="montant" id="montant" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="date">Date de paiement</label>
        <input type="date" name="date" id="date" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="recu_paiement">Reçu de paiement</label>
        <input type="file" name="recu_paiement" id="recu_paiement" class="form-control">
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select name="status" id="status" class="form-control" required>
            <option value="non payé">Non payé</option>
            <option value="partiellement payé">Partiellement payé</option>
            <option value="payé">Payé</option>
        </select>
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
$(function () {
  bsCustomFileInput.init();
});
</script>

@endsection
