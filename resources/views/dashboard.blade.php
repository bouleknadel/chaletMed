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
                <div class="col-md-6 ">
                    @foreach ($coordoneeBanque as $coordonee)
                        @if ($coordonee->status == 1)
                            <div class="card ">
                                <div class="card-body"
                                    style="display: flex ; justify-content : space-between; flex-wrap: wrap;">


                                    <div>
                                        <div class="card-title">

                                            <h3 class="">Compte bancaire pour les versements de cotisations</h3>
                                        </div>
                                        <div class="bank-info">
                                            <br>
                                            <div class="bank-info-row">
                                                <span class="icon"><i class="fas fa-credit-card"></i></span>
                                                <span class="label">Numéro de compte:</span>
                                                <span class="value">{{ $coordonee->numero_compte }}</span>
                                            </div>
                                            <div class="bank-info-row">
                                                <span class="icon"><i class="fas fa-building"></i></span>
                                                <span class="label">Raison sociale:</span>
                                                <span class="value">{{ $coordonee->raison_sociale }}</span>
                                            </div>
                                            <div class="bank-info-row">
                                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                                <span class="label">Ville:</span>
                                                <span class="value">{{ $coordonee->ville }}</span>
                                            </div>
                                            <div class="bank-info-row">
                                                <span class="icon"><i class="fas fa-university"></i></span>
                                                <span class="label">Banque:</span>
                                                <span class="value">{{ $coordonee->banque }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($coordonee->logo)
                                        <div class="logo-container">
                                            <img src="{{ asset('uploads/photos/' . $coordonee->logo) }}"
                                                alt="Logo de la banque" style="height: 70px; width: 70px;" class="logo">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-12">



                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="select-year" class="form-control" name="year">
                                        <option value="" disabled {{ empty($selected_year) ? 'selected' : '' }}>Toutes
                                            les
                                            années</option>
                                        @for ($year = 2018; $year <= $current_year; $year++)
                                            <?php $yearNext = $year + 1; ?>
                                            <option value="{{ $year }}"
                                                {{ $selected_year == $year || ($selected_year == null && $year == $current_year) ? 'selected' : '' }}>
                                                {{ $year . '/' . $yearNext }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-block btn-primary mb-4  ">Filtrer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_users }}</h3>

                            <p>Nombre total d'utilisateurs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pourcentage_paye }}<sup style="font-size: 20px">%</sup> -
                                {{ $chiffre_affaire_payé }} DH</h3>

                            <p>Cotisations payées <span style="font-size: 11px">(année en cours)</span> </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'paid']) }}"
                            class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-4 ">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $pourcentage_partiellement_paye }}<sup style="font-size: 20px">%</sup> -
                                {{ $chiffre_affaire_non_payé }} DH</h3>

                            <p>Cotisations partiellemt paye <span style="font-size: 11px">(année en cours)</span></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'partially_paid']) }}"
                            class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 ">
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
                        <a href="{{ route('cotisations.showCurrentYearCotisations', ['status' => 'unpaid']) }}"
                            class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 ">
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
                <div class="col-lg-4 ">
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
                    $total_charges = 0;
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
                        $total_charges += $montant;
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

                @foreach ($membres as $membre)
                    <div class="col-md-2 col-sm-6 col-lg-3 mb-4">
                        <div class="card" style="padding : 5px ; font-size : 16px ;">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                                @if ($membre->photo)
                                    <div>
                                        <a href="{{ asset('uploads/photos/' . $membre->photo) }}" download>
                                            <img src="{{ asset('uploads/photos/' . $membre->photo) }}"
                                                class="img-fluid square-img mb-3" alt="Photo du membre">
                                        </a>
                                    </div>
                                @else
                                    <div>
                                        <span class="text-muted">Pas de photo</span>
                                    </div>
                                @endif
                                <h5 class="card-title font-weight-bold text-center" style="font-size: 16px; margin: 0;">
                                    {{ $membre->nom }}</h5>
                                <p class="card-text text-center" style="font-size: 13px;">{{ $membre->fonction }}</p>

                                <!--<div class="d-flex justify-content-center">

                                                                                                    </div>-->

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
                @php
                    $agentsSecurite = $agentsSecurite->sortBy(function ($agent) {
                        switch ($agent->fonction) {
                            case 'Chef de sécurité':
                                return 1;
                            case 'Agent jardiner':
                                return 2;
                            case 'Agent de sécurité':
                                return 3;
                            default:
                                return 4;
                        }
                    });
                @endphp

                @foreach ($agentsSecurite as $agent)
                    <div class="col-md-2 col-sm-6 col-lg-3 mb-4">
                        <div class="card" style="">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                                @if ($agent->photo)
                                    <div>
                                        <a href="{{ asset('uploads/photos/' . $agent->photo) }}" download>
                                            <img src="{{ asset('uploads/photos/' . $agent->photo) }}"
                                                class="img-fluid square-img mb-3" alt="Photo de l'agent de sécurité">
                                        </a>
                                    </div>
                                @else
                                    <div>
                                        <span class="text-muted">Pas de photo</span>
                                    </div>
                                @endif
                                <h5 class="card-title font-weight-bold text-center" style="font-size: 16px; margin: 0;">
                                    {{ $agent->nom }}</h5>
                                <p class="card-text text-center" style="font-size: 13px;">{{ $agent->fonction }}</p>
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
