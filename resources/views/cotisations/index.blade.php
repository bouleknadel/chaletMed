@extends('layouts.master')


@section('title')
Listes des cotisations
@endsection



@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection



@section('title_page')

@endsection


@section('title_page2')

@endsection



@section('content2')
@if(session('successedit'))
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
                        <h3 class="card-title">Table des cotisations</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!--filter les annes-->

    <div class="col-md-8 filtre">
        <form action="{{ route('cotisations.index') }}" method="GET">
        <label for="select-year">Année :</label>
        <select id="select-year" class="form-control filter" onchange="this.form.submit()" name="year">
            <option value="" disabled {{ empty($selectedYear) ? 'selected' : '' }}>Toutes les années</option>
            @foreach ($years as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
        </form>
        <form action="{{ route('cotisations.index') }}" method="GET">
            <label for="select-letter">N° du chalet :</label>
            <select id="select-letter" class="form-control filter" onchange="this.form.submit()" name="letter">
                <option value="" selected disabled>Toutes les lettres</option>
                <option value="A" {{ $selectedLetter == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ $selectedLetter == 'B' ? 'selected' : '' }}>B</option>
            </select>
        </form>
        <form action="{{ route('cotisations.index') }}" method="GET">
            <label for="select-status">Statut de paiement :</label>
            <select id="select-status" class="form-control filter" onchange="this.form.submit()" name="status">
                <option value="" selected disabled>Tous les statuts de paiement</option>
                <option value="payé" {{ $selectedStatus == 'payé' ? 'selected' : '' }}>Payé</option>
                <option value="partiellement payé" {{ $selectedStatus == 'partiellement payé' ? 'selected' : '' }}>Partiellement payé</option>
                <option value="non payé" {{ $selectedStatus == 'non payé' ? 'selected' : '' }}>Non payé</option>
            </select>
        </form>

    </div>




                            </form>

                        </div>


                        <!---------->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N° du chalet</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Recu Paiement</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cotisations as $cotisation)
                                <tr>
                                    <td>{{ $cotisation->user->numero_devilla }}</td>
                                    <td>{{ $cotisation->user->name }}</td>
                                    <td>{{ $cotisation->user->lastname }}</td>
                                    <td>{{ $cotisation->montant }} DH</td>
                                    <td>{{ $cotisation->date }}</td>
                                    <td>
                                        @if($cotisation->recu_paiement)
                                        <a href="{{ asset('uploads/recus/'.$cotisation->recu_paiement) }}" download>
                                            <img src="{{ asset('uploads/recus/'.$cotisation->recu_paiement) }}" height="40" width="40" class="img-responsive" alt="recu">
                                        </a>
                                        @else
                                        Pas de recus
                                        @endif
                                    </td>
                                    <td class="@if($cotisation->status == 'payé') text-success @elseif($cotisation->status == 'partiellement payé') text-info @else text-danger @endif">
                                        <strong>
                                            @if($cotisation->status == 'payé')
                                            <i class="fas fa-check-circle"></i> Payé
                                            @elseif($cotisation->status == 'partiellement payé')
                                            <i class="fas fa-exclamation-circle"></i>  Partiellement payé
                                            @else
                                            <i class="fas fa-times-circle"></i> Non payé
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $cotisation->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $cotisation->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $cotisation->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $cotisation->id }}">Modifier la cotisation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('cotisations.update', $cotisation->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="user_id">Utilisateur</label>
                                                                <select name="user_id" id="user_id" class="form-control" required>
                                                                    @foreach($users as $user)
                                                                    <option value="{{ $user->id }}" {{ $cotisation->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="montant">Montant</label>
                                                        <input type="number" name="montant" id="montant" class="form-control" value="{{ $cotisation->montant }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" name="date" id="date" class="form-control" value="{{ $cotisation->date }}" required>
                                                        </div>
                                                        <div classm="form-group">
                                                        <label for="recu_paiement">Reçu de paiement</label>
                                                        <input type="file" name="recu_paiement" id="recu_paiement" class="form-control-file">
                                                        @if($cotisation->recu_paiement)
                                                        <br>
                                                        <a href="{{ asset('uploads/recus/'.$cotisation->recu_paiement) }}" download>
                                                        Télécharger le fichier
                                                        </a>
                                                        @endif
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select name="status" id="status" class="form-control" required>
                                                        <option value="">Sélectionner un status</option>
                                                        <option value="payé" @if($cotisation->status == 'payé') selected @endif>Payé</option>
                                                        <option value="partiellement payé" @if($cotisation->status == 'partiellement payé') selected @endif>Partiellement payé</option>
                                                        <option value="non payé" @if($cotisation->status == 'non payé') selected @endif>Non payé</option>
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
                                                        <form method="POST" action="{{ route('cotisations.destroy', $cotisation->id) }}" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette cotisation?')">
                                                        <i class="fas fa-trash"></i>
                                                        </button>
                                                        </form>
                                                        </td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>

                                                        </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                        </div>
                                                        </div>
                                                        </div>

                                                        </section>

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
 $(function () {
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
      {
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
