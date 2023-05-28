@extends('layouts.master')

@section('title')
    Autre parametres
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
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>{{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="row">
          <div class="col-md-8 m-auto">
            <div class="card card-primary">
              <div class="card-header" style="margin-bottom: 5px;">
                <h3 class="card-title" style="font-size: 16px; margin-bottom: 0;">Coordonnées bancaires</h3>
              </div>
              <div class="card-body" style="padding: 10px;">
                <form action="{{ route('parametre.storeCoordonee') }}" method="POST">
                  @csrf

                  <div class="form-group row" style="margin-bottom: 10px;">
                    <div class="col-sm-6">
                      <label for="numero_compte" style="font-size: 14px;">Numéro de compte</label>
                      <input type="text" name="numero_compte" id="numero_compte" class="form-control" style="font-size: 12px;" required>
                    </div>
                    <div class="col-sm-6">
                      <label for="raison_sociale" style="font-size: 14px;">Raison sociale de la banque</label>
                      <input type="text" name="raison_sociale" id="raison_sociale" class="form-control" style="font-size: 12px;" required>
                    </div>
                  </div>

                  <div class="form-group" style="margin-bottom: 10px;">
                    <label for="ville" style="font-size: 14px;">Ville</label>
                    <input type="text" name="ville" id="ville" class="form-control" style="font-size: 12px;" required>
                  </div>

                  <div class="form-group" style="margin-bottom: 10px;">
                    <label for="banque" style="font-size: 14px;">Banque</label>
                    <input type="text" name="banque" id="banque" class="form-control" style="font-size: 12px;" required>
                  </div>

                  <div class="form-group" style="margin-bottom: 10px;">
                    <label for="cle" style="font-size: 14px;">Clé</label>
                    <input type="text" name="cle" id="cle" class="form-control" style="font-size: 12px;" required>
                  </div>

                  <button type="submit" class="btn btn-primary" style="font-size: 14px;">Enregistrer</button>
                </form>
              </div>
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
