@extends('layouts.master')


@section('title')
cree charge
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
        <div class="col-md-9 m-auto">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ajouter une charge</h3>
                </div>
                <form method="POST" action="{{ route('charges.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="rubrique">Rubrique</label>
                            <select name="rubrique" id="rubrique" class="form-control" required>
                                <option value="">Sélectionner une rubrique</option>
                                <option value="Sécurité">Sécurité</option>
                                <option value="Jardinage">Jardinage</option>
                                <option value="Charges annexes">Charges annexes</option>
                                <option value="Divers">Divers</option>
                                <option value="Salaire">Salaire</option>
                                <option value="Plomberie">Plomberie</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant</label>
                            <input type="number" name="montant" id="montant" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Sélectionner un type</option>
                                <option value="charge_fixe_mensuelle">Charge fixe mensuelle</option>
                                <option value="charge_occasionnelle">Charge occasionnelle</option>
                                <option value="charge_annuelle">Charge annuelle</option> <!-- Nouvelle option -->
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="recus">Reçus</label>
                            <input type="file" name="recus" id="recus" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="non paye">Non payé</option>
                                <option value="paye">Payé</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
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
