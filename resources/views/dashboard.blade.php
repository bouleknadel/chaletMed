@extends('layouts.master')


@section('title')
Dashboard
@endsection



@section('css')

@endsection



@section('title_page')
Admin dashboard
@endsection


@section('title_page2')
Dashboard
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
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $pourcentage_partiellement_paye }}<sup style="font-size: 20px">%</sup> -
            {{$chiffre_affaire_non_payé}} DH</h3>

              <p>Cotisations partiellemt paye <span style="font-size: 11px">(année en cours)</span></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'partially_paid']) }}" class="small-box-footer">More info  <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $pourcentage_non_paye }}<sup style="font-size: 20px">%</sup>
            </h3>

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

      <div class="row">
        <div class="col-12">
            <h4 class="text-center mb-4 mt-3 text-bold">Chiffre d'affaires des charges par catégorie</h4>
        </div>
    </div>
    <!-- Affichage des chiffres d'affaires des charges par catégorie -->


<!-- Affichage des chiffres d'affaires des charges par catégorie -->
<div class="row">
    @php
 $total_charges = 0 ;
    @endphp
    @foreach ($rubriques_charges as $rubrique => $montant)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $montant }} DH</h3>
                    <p>{{ $rubrique }}</p>
                </div>
                <div class="icon">
                    @if ($rubrique === 'Sécurité')
                        <i class="fas fa-shield-alt"></i>
                    @elseif ($rubrique === 'Jardinage')
                        <i class="fas fa-tree"></i>
                    @elseif ($rubrique === 'Charges annexes')
                        <i class="fas fa-cogs"></i>
                    @elseif ($rubrique === 'Divers')
                        <i class="fas fa-ellipsis-h"></i>
                    @elseif ($rubrique === 'Salaire')
                        <i class="fas fa-money-bill"></i>
                    @elseif ($rubrique === 'Plomberie')
                        <i class="fas fa-faucet"></i>
                    @else
                        <i class="fas fa-question-circle"></i>
                    @endif
                </div>
            </div>
        </div>
        @php
        $total_charges +=  $montant ;
           @endphp
    @endforeach

    <!-- Card pour afficher le total avec une icône -->
    <div class="col-lg-4 col-6">
        <div class="small-box  total-card" style="background-color: #f39c12;">
            <div class="inner">
                <h3>{{ $total_charges }} DH</h3>
                <p>Total des charges</p>
            </div>
            <div class="icon">
                <i class="fas fa-calculator"></i>
            </div>
        </div>
    </div>

</div>



      <div class="row">
        <div class="col-12">
            <h4 class="text-center mb-4 mt-3 text-bold">Liste des membres du bureau exécutif</h4>
        </div>
    </div>
    <div class="row">
        @php
        $membres = $membres->sortBy(function ($membre) {
            switch ($membre->fonction) {
                case 'Président':
                    return 1;
                case 'Premier vice président exécutif':
                    return 2;
                case 'Trésorier':
                    return 3;
                case 'Responsable juridique':
                    return 4;
                default:
                    return 5;
            }
        });
        @endphp

        @foreach($membres as $membre)
            <div class="col-md-2 col-sm-6 col-lg-3 mb-4">
                <div class="card" style="width: 200px; height: 300px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                        @if($membre->photo)
                            <div>
                                <a href="{{ asset('uploads/photos/'.$membre->photo) }}" download>
                                    <img src="{{ asset('uploads/photos/'.$membre->photo) }}" class="img-fluid square-img mb-3" alt="Photo du membre">
                                </a>
                            </div>
                        @else
                            <div>
                                <span class="text-muted">Pas de photo</span>
                            </div>
                        @endif
                        <h5 class="card-title font-weight-bold text-center" style="font-size: 14px; margin: 0;">{{ $membre->nom }}</h5>
                        <p class="card-text text-center" style="font-size: 12px;">{{ $membre->fonction }}</p>

                        <div class="d-flex justify-content-center">
                            <a href="#" class="mr-3" data-toggle="modal" data-target="#modal-{{ $membre->id }}">
                                <i class="fas fa-edit"></i> <!-- Icône pour modifier -->
                            </a>

                            <form action="{{ route('parametre.destroyBureau', $membre->id) }}" method="post" style="display: inline-block" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size : 9px ;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-{{ $membre->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $membre->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-{{ $membre->id }}">Modifier les informations</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('parametre.updateBureau', $membre->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="photo">Photo :</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>

                                <div class="form-group">
                                    <label for="nom">Nom :</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $membre->nom }}">
                                </div>

                                <div class="form-group">
                                    <label for="fonction">Fonction :</label>
                                    <select class="form-control" id="fonction" name="fonction">
                                        <option value="Président" {{ $membre->fonction == 'Président' ? 'selected' : '' }}>Président</option>
                                        <option value="Premier vice président exécutif" {{ $membre->fonction == 'Premier vice président exécutif' ? 'selected' : '' }}>Premier vice président exécutif</option>
                                        <option value="Trésorier" {{ $membre->fonction == 'Trésorier' ? 'selected' : '' }}>Trésorier</option>
                                        <option value="Responsable juridique" {{ $membre->fonction == 'Responsable juridique' ? 'selected' : '' }}>Responsable juridique</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="text-center mb-4 mt-3 text-bold">Liste des agents de sécurité</h4>
        </div>
    </div>
    <div class="row">
        @foreach($agentsSecurite as $agent)
            <div class="col-md-2 col-sm-6 col-lg-3 mb-4">
                <div class="card" style="width: 200px; height: 300px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                        @if($agent->photo)
                            <div>
                                <a href="{{ asset('uploads/photos/'.$agent->photo) }}" download>
                                    <img src="{{ asset('uploads/photos/'.$agent->photo) }}" class="img-fluid square-img mb-3" alt="Photo de l'agent de sécurité">
                                </a>
                            </div>
                        @else
                            <div>
                                <span class="text-muted">Pas de photo</span>
                            </div>
                        @endif
                        <h5 class="card-title font-weight-bold text-center" style="font-size: 14px; margin: 0;">{{ $agent->nom }}</h5>
                        <p class="card-text text-center" style="font-size: 12px;">{{ $agent->fonction }}</p>

                        <div class="d-flex justify-content-center">
                            <a href="#" class="mr-3" data-toggle="modal" data-target="#modal-{{ $agent->id }}">
                                <i class="fas fa-edit"></i> <!-- Icône pour modifier -->
                            </a>

                            <form action="{{ route('parametre.destroyBureau', $agent->id) }}" method="post" style="display: inline-block" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size : 9px ;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-{{ $agent->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $agent->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-{{ $agent->id }}">Modifier les informations</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('parametre.updateBureau', $agent->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="photo">Photo :</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>

                                <div class="form-group">
                                    <label for="nom">Nom :</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $agent->nom }}">
                                </div>

                                <div class="form-group">
                                    <label for="fonction">Fonction :</label>
                                    <select class="form-control" id="fonction" name="fonction">
                                        <option value="Chef de sécurité" {{ $agent->fonction == 'Chef de sécurité' ? 'selected' : '' }}>Chef de sécurité</option>
                                        <option value="Agent jardinier" {{ $agent->fonction == 'Agent jardinier' ? 'selected' : '' }}>Agent jardinier</option>
                                        <option value="Agent de sécurité" {{ $agent->fonction == 'Agent de sécurité' ? 'selected' : '' }}>Agent de sécurité</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



      <!-- Main row -->

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection


@section('scripts')

@endsection
