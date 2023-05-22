@extends('layouts.master')


@section('title')
Modifier Utilisateur
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



<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-9 m-auto">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Modifier l'utilisateur {{ $user->name }} {{$user->lastname }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="role">Rôle</label>
                            <select class="form-control" id="role" name="role" value="{{ $user->role }}">
                                <option value="admin">Admin</option>
                                <option value="user">Utilisateur</option>
                                <option value="syndic">Syndic</option>
                                <!-- Ajoutez les autres options de rôle ici -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Prénom</label>
                            <input type="text" name="lastname" class="form-control" id="lastname" value="{{ $user->lastname }}" placeholder="Prénom">
                        </div>
                        <div class="form-group">
                            <label for="numero_devilla">Numéro de villa</label>
                            <input type="text" name="numero_devilla" class="form-control" id="numero_devilla" value="{{ $user->numero_devilla }}" placeholder="Numéro de villa">
                        </div>
                        <div class="form-group">
                            <label for="numero_de_telephone">Numéro de téléphone</label>
                            <input type="text" name="numero_de_telephone" class="form-control" id="numero_de_telephone" value="{{ $user->numero_de_telephone }}" placeholder="Numéro de téléphone">
                        </div>
                        <div class="form-group">
                            <label for="numero_de_telephone2">Numéro de téléphone 2</label>
                            <input type="text" name="numero_de_telephone2" class="form-control" id="numero_de_telephone2" value="{{ $user->numero_de_telephone2 }}" placeholder="Numéro de téléphone 2">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
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
@endsection
