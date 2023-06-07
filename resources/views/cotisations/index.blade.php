@extends('layouts.master')


@section('title')
    Listes des cotisations
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
    Cotisations
@endsection


@section('title_page2')
@endsection



@section('content2')
    @if (session('successedit'))
        <div class="alert alert-info text-white" style="background-color: #17a2b8;">
            <i class="fas fa-edit"></i> {{ session('successedit') }}
        </div>
    @endif

    @if (session('successdelete'))
        <div class="alert alert-danger text-white" role="alert">
            <i class="fas fa-trash-alt mr-2"></i>{{ session('successdelete') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-white" role="alert">
            <i class="fas fa-trash-alt mr-2"></i>{{ session('error') }}
        </div>
    @endif



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Table des cotisations</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (Auth::user()->role != 'syndic')
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#addCotisationModal" style="margin-bottom : 10px ;">
                                    Ajouter cotisation
                                </button>
                            @endif
                            <!--filter les annes-->

                            <div class="col-md-12 ">
                                <form action="{{ route('cotisations.index') }}" method="GET" class="filter-form">
                                    <div class="row">
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="select-year">Année :</label>
                                                <select id="select-year" class="form-control" name="year">
                                                    <option value="" {{ empty($selectedYear) ? 'selected' : '' }}>
                                                        Toutes les années
                                                    </option>

                                                    @foreach ($annees as $year)
                                                        @php
                                                            $next_a = intval($year->annee) + 1;
                                                            $yearRange = $year->annee . '/' . $next_a;
                                                        @endphp
                                                        <option value="{{ $year->annee }}"
                                                            {{ $selectedYear == $year->annee ? 'selected' : '' }}>
                                                            {{ $yearRange }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="select-letter">Utilisateur :</label>
                                                <select name="search_user" id="search_user" class="form-control">
                                                    <option value="" selected>Sélectionner...</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (old('search_user') == $user->id) selected @endif>
                                                            {{ $user->name }} ({{ $user->numero_devilla }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="select-status">Statut de paiement :</label>
                                                <select id="select-status" class="form-control" name="status">
                                                    <option value="" selected>Tous les statuts de
                                                        paiement</option>
                                                    <option value="payé"
                                                        {{ $selectedStatus == 'payé' ? 'selected' : '' }}>Payé</option>
                                                    <option value="partiellement payé"
                                                        {{ $selectedStatus == 'partiellement payé' ? 'selected' : '' }}>
                                                        Partiellement payé</option>
                                                    <option value="non payé"
                                                        {{ $selectedStatus == 'non payé' ? 'selected' : '' }}>Non payé
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="select-validation-status">Statut de validation :</label>
                                                <select id="select-validation-status" class="form-control "
                                                    name="validation_status">
                                                    <option value="" selected>Tous les statuts de
                                                        validation</option>
                                                    <option value="Validé"
                                                        {{ $selectedValidationStatus == 'Validé' ? 'selected' : '' }}>
                                                        Validé</option>
                                                    <option value="en attente"
                                                        {{ $selectedValidationStatus == 'en attente' ? 'selected' : '' }}>
                                                        En attente</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mt-2 ff">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block"
                                                style="font-size: 17px; font-weight : 600 ;">Filtrer</button>
                                        </div>
                                    </div>

                                </form>
                            </div>


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>N° du chalet</th>
                                        <th>Nom et Prénom</th>
                                        <th>Contact</th>
                                        <!-- <th>Prénom</th> -->
                                        <th>Montant</th>
                                        <th>Date de paiement </th>
                                        <th>Année</th>
                                        <th>Recu Paiement</th>
                                        <th>Status</th>
                                        <th>Status validation</th>
                                        @if (Auth::user()->role != 'syndic')
                                            <th>Action</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Trier les cotisations par ordre : non payé, en attente, payé
                                        $sortedCotisations = $cotisations->sortBy(function ($cotisation) {
                                            if ($cotisation->status === 'non payé') {
                                                return 0;
                                            } elseif ($cotisation->statuValidation === 'en attente') {
                                                return 1;
                                            } elseif ($cotisation->status === 'payé') {
                                                return 2;
                                            }
                                        });
                                    @endphp
                                    @foreach ($cotisations as $cotisation)
                                        <tr class="{{ $cotisation->statuValidation === 'validé' ? 'validé' : '' }}">
                                            <td>{{ $cotisation->user->numero_devilla }}</td>
                                            <td> {{ $cotisation->user->name }} {{ $cotisation->user->lastname }} </td>
                                            <td> {{ $cotisation->user->numero_de_telephone }} </td>
                                            <!--   <td> $cotisation->user->lastname </td> -->
                                            <td>{{ $cotisation->montant }} DH</td>
                                            <td>{{ $cotisation->date }}</td>

                                            @php
                                                $annee = $cotisation->annee;
                                                $anneeplus = intval($cotisation->annee) + 1;
                                            @endphp
                                            @if ($annee)
                                                <td class="text-bold">{{ $annee }}/{{ $anneeplus }}</td>
                                            @else
                                                <td>pas d'année </td>
                                            @endif


                                            <td>
                                                @if ($cotisation->recu_paiement)
                                                    <a href="{{ asset('uploads/recus/' . $cotisation->recu_paiement) }}"
                                                        download>
                                                        <img src="{{ asset('uploads/recus/' . $cotisation->recu_paiement) }}"
                                                            height="40" width="40" class="img-responsive"
                                                            alt="recu">
                                                    </a>
                                                @else
                                                    Pas de recus
                                                @endif
                                            </td>
                                            <td
                                                class="@if ($cotisation->status == 'payé') text-success @elseif($cotisation->status == 'partiellement payé') text-info @else text-danger @endif">
                                                <strong>
                                                    @if ($cotisation->status == 'payé')
                                                        <i class="fas fa-check-circle"></i> Payé
                                                    @elseif($cotisation->status == 'partiellement payé')
                                                        <i class="fas fa-exclamation-circle"></i> Partiellement payé
                                                    @else
                                                        <i class="fas fa-times-circle"></i> Non payé
                                                    @endif
                                                </strong>
                                            </td>
                                            <td>
                                                @if ($cotisation->statuValidation == 'validé')
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @else
                                                    <i class="fas fa-clock text-warning"></i>
                                                @endif
                                                {{ $cotisation->statuValidation }}
                                            </td>
                                            @if (Auth::user()->role != 'syndic')
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#editModal{{ $cotisation->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal{{ $cotisation->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editModalLabel{{ $cotisation->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $cotisation->id }}">Modifier
                                                                        la
                                                                        cotisation</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('cotisations.update', $cotisation->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="user_id">Utilisateur</label>
                                                                            <select name="user_id" id="user_id"
                                                                                class="form-control" required>
                                                                                @foreach ($users as $user)
                                                                                    <option value="{{ $user->id }}"
                                                                                        {{ $cotisation->user_id == $user->id ? 'selected' : '' }}>
                                                                                        {{ $user->name }}
                                                                                        ({{ $user->email }})
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="montant">Montant</label>
                                                                            <input type="number" name="montant"
                                                                                id="montant" class="form-control"
                                                                                value="{{ $cotisation->montant }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="date">Date de paiement</label>
                                                                            <input type="date" name="date"
                                                                                id="date" class="form-control"
                                                                                value="{{ $cotisation->date }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="date">Année</label>
                                                                            <select name="annee" id="annee"
                                                                                class="form-control" required>

                                                                                @foreach ($annees as $year)
                                                                                    @php
                                                                                        $yearRange = $year->annee . '/' . (intval($year->annee) + 1);
                                                                                    @endphp
                                                                                    <option value="{{ $year->annee }}"
                                                                                        @if (intval($cotisation->annee) == intval($year->annee)) selected @endif>
                                                                                        {{ $yearRange }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div classm="form-group">
                                                                            <label for="recu_paiement">Reçu de
                                                                                paiement</label>
                                                                            <input type="file" name="recu_paiement"
                                                                                id="recu_paiement"
                                                                                class="form-control-file">
                                                                            @if ($cotisation->recu_paiement)
                                                                                <br>
                                                                                <a href="{{ asset('uploads/recus/' . $cotisation->recu_paiement) }}"
                                                                                    download>
                                                                                    Télécharger le fichier
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="status">Status</label>
                                                                            <select name="status" id="status"
                                                                                class="form-control" required>
                                                                                <option value="">Sélectionner un
                                                                                    status
                                                                                </option>
                                                                                <option value="payé"
                                                                                    @if ($cotisation->status == 'payé') selected @endif>
                                                                                    Payé</option>
                                                                                <option value="partiellement payé"
                                                                                    @if ($cotisation->status == 'partiellement payé') selected @endif>
                                                                                    Partiellement payé</option>
                                                                                <option value="non payé"
                                                                                    @if ($cotisation->status == 'non payé') selected @endif>
                                                                                    Non payé</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="statuValidation">Statut
                                                                                Validation</label>
                                                                            <select name="statuValidation"
                                                                                id="statuValidation" class="form-control">
                                                                                <option value="valide"
                                                                                    {{ $cotisation->statuValidation == 'valide' ? 'selected' : '' }}>
                                                                                    validé</option>
                                                                                <option value="en attente"
                                                                                    {{ $cotisation->statuValidation == 'en attente' ? 'selected' : '' }}>
                                                                                    En attente</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Fermer</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Enregistrer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('cotisations.destroy', $cotisation->id) }}"
                                                        style="display: inline-block;" class="mt-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette cotisation?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>




                        </div>


                        <!---------->

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        </div>

    </section>

    <!-- Modal -->
    <div class="modal fade" id="addCotisationModal" tabindex="-1" role="dialog" aria-labelledby="addCotisationLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCotisationLabel">Ajouter cotisation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('cotisations.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">

                        @csrf

                        <div class="form-group">
                            <label for="user_id">Utilisateur</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach ($users as $user)
                                    @if ($user->role == 'user')
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                        </option>
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
                            <label for="date">Année</label>
                            <select name="annee" id="annee" class="form-control" required>
                                @foreach ($annees as $year)
                                    @php
                                        $yearRange = $year->annee . '/' . (intval($year->annee) + 1);
                                    @endphp
                                    <option value="{{ $year->annee }}">
                                        {{ $yearRange }}
                                    </option>
                                @endforeach
                            </select>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection





@section('scripts')
    <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i> Copier',
                        className: 'btn btn-primary',
                        titleAttr: 'Copier dans le presse-papier'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-primary',
                        titleAttr: 'Exporter en CSV'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-primary',
                        titleAttr: 'Exporter en Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-primary',
                        titleAttr: 'Exporter en PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimer',
                        className: 'btn btn-primary',
                        titleAttr: 'Imprimer le tableau',
                        messageTop: ' '
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
