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
    @if(session('successedit'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>{{ session('successedit') }}
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
                <form action="{{ route('parametre.storeCoordonee') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="status" style="font-size: 14px;">Statut</label>
                    <select name="status" id="status" class="form-control" style="font-size: 12px;" required>
                        <option value="1" style="font-size: 14px ; ">Activé</option>
                        <option value="0" style="font-size: 14px ; ">Désactivé</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="logo">logo :</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
                  <button type="submit" class="btn btn-primary" style="font-size: 14px;">Enregistrer</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @php
          $coords = App\Models\CoordoneeBanque::all();
      @endphp
      <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Données</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Numéro de compte</th>
                                    <th>Raison sociale</th>
                                    <th>Ville</th>
                                    <th>Banque</th>
                                    <th>status</th>
                                    <th>logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coords as $coord)

                                <tr>
                                    <td>{{ $coord->numero_compte }}</td>
                                    <td>{{ $coord->raison_sociale }}</td>
                                    <td>{{ $coord->ville }}</td>
                                    <td>{{ $coord->banque }}</td>
                                    <td>
                                        @if ($coord->status == 1)
                                            <span class="text-success font-weight-bold">Activé</span>
                                        @else
                                            <span class="text-danger font-weight-bold">Désactivé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coord->logo)
                                            <a href="{{ asset('uploads/photos/'.$coord->logo) }}" download>
                                                <img src="{{ asset('uploads/photos/'.$coord->logo) }}" height="40" width="40" class="img-responsive" alt="logo">
                                            </a>
                                        @else
                                            Pas de logo
                                        @endif
                                    </td>


                                    <td><!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $coord->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Modal de modification -->
                                        <div class="modal fade" id="editModal{{ $coord->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $coord->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $coord->id }}">Modifier la coordonnée bancaire</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('coordonee_banques.update', $coord->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="numero_compte">Numéro de compte</label>
                                                                <input type="text" name="numero_compte" id="numero_compte" class="form-control" value="{{ $coord->numero_compte }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="raison_sociale">Raison sociale</label>
                                                                <input type="text" name="raison_sociale" id="raison_sociale" class="form-control" value="{{ $coord->raison_sociale }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ville">Ville</label>
                                                                <input type="text" name="ville" id="ville" class="form-control" value="{{ $coord->ville }}" required>
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="banque">Banque</label>
                                                                <input type="text" name="banque" id="banque" class="form-control" value="{{ $coord->banque }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="logo">Logo de la banque</label>
                                                                <input type="file" name="logo" id="logo" class="form-control-file">
                                                                @if($coord->logo)
                                                            <br>
                                                            <a href="{{ asset('uploads/photos/'.$coord->logo) }}"  download>
                                                            Télécharger le logo
                                                            </a>
                                                            @endif
                                                            </div>
                                                            <div class="form-group" style="margin-bottom: 10px;">
                                                                <label for="status" style="font-size: 14px;">Statut</label>
                                                                <select name="status" id="status" class="form-control" style="font-size: 12px;" required>
                                                                    <option value="1" {{ $coord->status == 1 ? 'selected' : '' }}>Activé</option>
                                                                    <option value="0" {{ $coord->status == 0 ? 'selected' : '' }}>Désactivé</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('coordonee_banques.destroy', $coord->id) }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette coordonnée bancaire?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
