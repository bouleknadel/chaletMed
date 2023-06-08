@extends('layouts.master')


@section('title')
    Liste balance
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
    Balance
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
                            <h3 class="card-title">Balance</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (Auth::user()->role != 'syndic')
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#addBalanceModal" style="margin-bottom : 10px ;">
                                    Ajouter
                                </button>
                            @endif



                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Année</th>
                                        <th>Montant</th>
                                        <th>Commentaire</th>
                                        <th>Date ajout</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $balance)
                                        <tr>
                                            <td>{{ $balance->id }}</td>
                                            <td>{{ $balance->annee }}/ {{ intval($balance->annee) + 1 }}</td>
                                            @if ($balance->debit)
                                                <td class="bg-info"> +{{ $balance->montant }}</td>
                                            @else
                                                <td class="bg-danger"> -{{ $balance->montant }}</td>
                                            @endif
                                            <td>{{ $balance->commentaire }}</td>
                                            <td>{{ \Carbon\Carbon::parse($balance->created_at)->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#editModal{{ $balance->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="editModal{{ $balance->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="editModalLabel{{ $balance->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $balance->id }}">
                                                                    Modification</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('balances.update', $balance->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">

                                                                    <div class="form-group">
                                                                        <label for="date">Année</label>
                                                                        <select name="annee" id="annee"
                                                                            class="form-control" required>
                                                                            @foreach ($annees as $year)
                                                                                @php
                                                                                    $yearRange = $year->annee . '/' . (intval($year->annee) + 1);
                                                                                @endphp
                                                                                <option
                                                                                    @if (intval($balance->annee) == intval($year->annee)) selected @endif
                                                                                    value="{{ $year->annee }}">
                                                                                    {{ $yearRange }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="date">Type</label>
                                                                        <select name="type" id="type"
                                                                            class="form-control" required>
                                                                            <option value="1"
                                                                                @if (intval($balance->type) == 1) selected @endif>
                                                                                DEBIT
                                                                            </option>
                                                                            <option value="0"
                                                                                @if (intval($balance->type) == 0) selected @endif>
                                                                                CREDIT
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="montant">Montant</label>
                                                                        <input type="number" name="montant" id="montant"
                                                                            class="form-control"
                                                                            value="{{ $balance->montant }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="commentaire">Commentaire</label>
                                                                        <textarea name="commentaire" id="commentaire" class="form-control">{{ $balance->commentaire }}</textarea>
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
                                                <form method="POST" action="{{ route('balances.destroy', $balance->id) }}"
                                                    style="display: inline-block;" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet element?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
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
    <div class="modal fade" id="addBalanceModal" tabindex="-1" role="dialog" aria-labelledby="addBalanceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBalanceLabel">Ajouter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('balances.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">

                        @csrf

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
                            <label for="date">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="1">
                                    DEBIT
                                </option>
                                <option value="0">
                                    CREDIT
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="montant">Montant</label>
                            <input type="number" name="montant" id="montant" class="form-control"
                                value="{{ old('montant') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="commentaire">Commentaire</label>
                            <textarea name="commentaire" id="commentaire" class="form-control">{{ old('commentaire') }}</textarea>
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

        });
    </script>
@endsection
