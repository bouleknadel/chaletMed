@extends('layouts.master')

@section('title')
    Créer un membre du bureau exécutif
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

    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9 m-auto">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter un membre</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('parametre.storeBureau')}}" enctype="multipart/form-data">

                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="photo">Photo :</label>
                                <input type="file" class="form-control" id="photo" name="photo" required>
                            </div>

                            <div class="form-group">
                                <label for="nom">Nom :</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez le nom" required>
                            </div>

                            <div class="form-group">
                                <label for="fonction">Fonction :</label>
                                <select class="form-control" id="fonction" name="fonction" required>
                                    <option value="Président">Président</option>
                                    <option value="Premier vice président exécutif">Premier vice président exécutif</option>
                                    <option value="Trésorier">Trésorier</option>
                                    <option value="Responsable juridique">Responsable juridique</option>
                                    <option value="Chef de sécurité">Chef de sécurité</option>
                                    <option value="Agent jadinier">Agent jadinier</option>
                                    <option value="Agent de sécurité">Agent de sécurité</option>
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
