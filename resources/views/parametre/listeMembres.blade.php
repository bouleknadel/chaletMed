@extends('layouts.master')


@section('title')
    liste membres
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
@endsection


@section('title_page2')
@endsection



@section('content2')
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>{{ session('success') }}
        </div>
    @endif
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Table des membres</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Fonction</th>
                                        <th>Carte d'identité</th> <!-- Nouvelle colonne -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($membres as $membre)
                                        <tr>
                                            <td>{{ $membre->nom }}</td>
                                            <td>{{ $membre->fonction }}</td>
                                            <td height="20" width="40" class="img-responsive">
                                                @if ($membre->carte_identite)
                                                    <a href="{{ asset('uploads/carte_identite/' . $membre->carte_identite) }}"
                                                        download>
                                                        <img src="{{ asset('uploads/carte_identite/' . $membre->carte_identite) }}"
                                                            height="20" width="40" class="img-responsive"
                                                            alt="carte_identite">
                                                    </a>
                                                @else
                                                    Pas de carte d'identité
                                                @endif
                                            </td> <!-- Affichage de la carte d'identité -->
                                            <td>
                                                <a href="#" class="mr-3" data-toggle="modal"
                                                    data-target="#modal-{{ $membre->id }}">
                                                    <i class="fas fa-edit"></i> <!-- Icône pour modifier -->
                                                </a>

                                                <form action="{{ route('parametre.destroyBureau', $membre->id) }}"
                                                    method="post" style="display: inline-block" class="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        style="font-size: 9px;"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-{{ $membre->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel-{{ $membre->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel-{{ $membre->id }}">
                                                            Modifier les informations</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('parametre.updateBureau', $membre->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-group">
                                                                <label for="photo">Photo :</label>
                                                                <input type="file" class="form-control" id="photo"
                                                                    name="photo">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="nom">Nom :</label>
                                                                <input type="text" class="form-control" id="nom"
                                                                    name="nom" value="{{ $membre->nom }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fonction">Fonction :</label>
                                                                <select class="form-control" id="fonction" name="fonction">
                                                                    <option value="Président"
                                                                        {{ $membre->fonction == 'Président' ? 'selected' : '' }}>
                                                                        Président</option>
                                                                    <option value="Premier vice président exécutif"
                                                                        {{ $membre->fonction == 'Premier vice président exécutif' ? 'selected' : '' }}>
                                                                        Premier vice président exécutif</option>
                                                                    <option value="Trésorier"
                                                                        {{ $membre->fonction == 'Trésorier' ? 'selected' : '' }}>
                                                                        Trésorier</option>
                                                                    <option value="Responsable juridique"
                                                                        {{ $membre->fonction == 'Responsable juridique' ? 'selected' : '' }}>
                                                                        Responsable juridique</option>
                                                                    <option value="Chef de sécurité"
                                                                        {{ $membre->fonction == 'Chef de sécurité' ? 'selected' : '' }}>
                                                                        Chef de sécurité</option>
                                                                    <option value="Agent jadinier"
                                                                        {{ $membre->fonction == 'Agent jadinier' ? 'selected' : '' }}>
                                                                        Agent jadinier</option>
                                                                    <option value="Agent de sécurité"
                                                                        {{ $membre->fonction == 'Agent de sécurité' ? 'selected' : '' }}>
                                                                        Agent de sécurité</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="carte_identite">Carte d'identité :</label>
                                                                <input type="file" class="form-control"
                                                                    id="carte_identite" name="carte_identite">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary">Enregistrer
                                                                    les modifications</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
