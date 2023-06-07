@extends('layouts.master')


@section('title')
    Liste document divers
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
    Document divers
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
                            <h3 class="card-title">Document divers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (Auth::user()->role != 'syndic')
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#addDocumentDiverModal" style="margin-bottom : 10px ;">
                                    Ajouter
                                </button>
                            @endif



                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Designation</th>
                                        <th>Document</th>
                                        <th>Date ajout</th>
                                        @if (Auth::user()->role != 'syndic')
                                            <th>Action</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $document_diver)
                                        <tr>
                                            <td>{{ $document_diver->id }}</td>
                                            <td>{{ $document_diver->designation }}</td>
                                            <td>
                                                @if ($document_diver->fichier)
                                                    <a href="{{ asset('uploads/document_diver/' . $document_diver->fichier) }}"
                                                        download>
                                                        <img src="{{ asset('uploads/document_diver/' . $document_diver->fichier) }}"
                                                            height="40" width="40" class="img-responsive"
                                                            alt="recu">
                                                    </a>
                                                @else
                                                    Pas de recus
                                                @endif
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($document_diver->created_at)->format('Y-m-d H:i:s') }}
                                            </td>



                                            @if (Auth::user()->role != 'syndic')
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#editModal{{ $document_diver->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal{{ $document_diver->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editModalLabel{{ $document_diver->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $document_diver->id }}">
                                                                        Modification</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('document_divers.update', $document_diver->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">

                                                                        <div class="form-group">
                                                                            <label for="designation">Designation</label>
                                                                            <input name="designation" id="designation"
                                                                                class="form-control"
                                                                                value="{{ $document_diver->designation }}"
                                                                                required>
                                                                        </div>
                                                                        <div classm="form-group">
                                                                            <label for="fichier">Document</label>
                                                                            <input type="file" name="fichier"
                                                                                id="fichier" class="form-control-file">
                                                                            @if ($document_diver->fichier)
                                                                                <br>
                                                                                <a href="{{ asset('uploads/document_diver/' . $document_diver->fichier) }}"
                                                                                    download>
                                                                                    Télécharger le fichier
                                                                                </a>
                                                                            @endif
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
                                                        action="{{ route('document_divers.destroy', $document_diver->id) }}"
                                                        style="display: inline-block;" class="mt-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet element?')">
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
    <div class="modal fade" id="addDocumentDiverModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentDiverLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentDiverLabel">Ajouter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('document_divers.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">

                        @csrf

                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <input name="designation" id="designation" class="form-control"
                                value="{{ old('designation') }}" required>
                        </div>
                        <div classm="form-group">
                            <label for="fichier">Document</label>
                            <input type="file" name="fichier" id="fichier" class="form-control-file">

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