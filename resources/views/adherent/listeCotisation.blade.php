@extends('layouts.master-user')


@section('title')
Listes de mes cotisations
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


@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle alert-icon"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle alert-icon"></i>{{ session('error') }}
    </div>
@endif
@if(session('errordelete'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle alert-icon"></i>{{ session('errordelete') }}
    </div>
@endif
@if(session('successedit'))
    <div class="alert alert-info text-white" style="background-color: #17a2b8;">
        <i class="fas fa-edit"></i> {{ session('successedit') }}
    </div>
@endif



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table des cotisations</h3>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addCotisationModal">Ajouter une cotisation</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Année</th>
                                    <th>Recu Paiement</th>
                                    <th>Status</th>
                                    <th>Status validation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cotisations as $cotisation)
                                <tr>
                                    <td>{{ $cotisation->user->name }}</td>
                                    <td>{{ $cotisation->user->lastname }}</td>
                                    <td>{{ $cotisation->montant }} DH</td>
                                    <td>{{ $cotisation->date }}</td>
                                    @php
                                    $annee =  $cotisation->annee ;
                                    $anneeplus =  $cotisation->annee+1 ;
                                 @endphp
                                     @if ($annee)
                                        <td class="text-bold">{{$annee}}/{{$anneeplus}}</td>
                                    @else
                                    <td>pas d'année </td>
                                     @endif
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
                                    <td>
                                        @if ($cotisation->statuValidation == 'en attente')
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $cotisation->id }}"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('adherent.destroy', $cotisation->id) }}" method="post" style="display: inline-block" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary" disabled><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('adherent.destroy', $cotisation->id) }}" method="post" style="display: inline-block" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" disabled><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif

                                          <!-- Modal de modification -->
                    <div class="modal fade" id="editModal{{ $cotisation->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $cotisation->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $cotisation->id }}Label">Modifier la cotisation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('adherent.update', $cotisation) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="montant">Montant:</label>
                                            <input type="number" class="form-control" id="montant" name="montant" value="{{ $cotisation->montant }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Date:</label>
                                            <input type="date" class="form-control" id="date" name="date" value="{{ $cotisation->date }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recu_paiement">Recu de paiement:</label>
                                            <input type="file" class="form-control" id="recu_paiement" name="recu_paiement">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                                      </td>
                                </tr>
                                @endforeach
                            </tfoot>
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

   <!-- Modal -->
<div class="modal fade" id="addCotisationModal" tabindex="-1" role="dialog" aria-labelledby="addCotisationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCotisationModalLabel">Ajouter une cotisation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('adherent.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" placeholder="Entrer le montant" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Entrer la date">
                    </div>
                    <div class="form-group">
                        <label for="recu_paiement">Recu de paiement</label>
                        <input type="file" class="form-control-file" id="recu_paiement" name="recu_paiement">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

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
