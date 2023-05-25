@extends('layouts.master')


@section('title')
Listes des charges
@endsection



@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection



@section('title_page')
Charges
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
              <h3 class="card-title">Table des charges</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addChargeModal" style="margin-bottom : 10px ;">
                    Ajouter charge
                  </button>
              <table id="example1" class="table table-bordered table-striped" >
                <thead >
                  <tr>
                    <th>Rubrique</th>
                    <th>Description</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Date de paiement</th>
                    <th>Année</th>
                    <th>Recus</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($charges as $charge)
                    <tr>
                      <td>{{ $charge->rubrique }}</td>
                      <td>{{ $charge->description }}</td>
                      <td>{{ $charge->montant }}</td>
                      <td>{{ $charge->type }}</td>
                      <td>{{ $charge->date }}</td>

                                     @php
                                    $annee =  $charge->annee ;
                                    $anneeplus =  $charge->annee+1 ;
                                 @endphp
                                     @if ($annee)
                                        <td class="text-bold">{{$annee}}/{{$anneeplus}}</td>
                                    @else
                                    <td>pas d'année </td>
                                     @endif

                      <td>
                        @if($charge->recus)
                          <a href="{{ asset('uploads/charges/'.$charge->recus) }}"  download>
                            <img src="{{ asset('uploads/charges/'.$charge->recus) }}" height="40" width="40" class="img-responsive" alt="recu">
                          </a>
                          @else
                            Pas de recus
                       @endif
                      </td>

                      <td class="@if($charge->status == 'paye') text-success @else text-danger @endif">
                        <strong>
                          @if($charge->status == 'paye')
                            <i class="fas fa-check-circle"></i> Paye
                          @else
                            <i class="fas fa-times-circle"></i> Non paye
                          @endif
                        </strong>
                      </td>

                      <td>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editChargeModal{{ $charge->id }}"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('charges.destroy', $charge->id) }}" method="post" style="display: inline-block" class="mt-1">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
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
  </section>
  <!-- /.content -->
  <!-- Modal de modification -->
@foreach ($charges as $charge)
<div class="modal fade" id="editChargeModal{{ $charge->id }}" tabindex="-1" role="dialog" aria-labelledby="editChargeLabel{{ $charge->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editChargeLabel{{ $charge->id }}">Modifier la charge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('charges.update', $charge->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <!-- Insérez les champs du formulaire de modification ici -->
          <div class="form-group">
            <label for="rubrique">Rubrique</label>
            <select name="rubrique" id="rubrique" class="form-control" required>
                <option value="">Sélectionner une rubrique</option>
                <option value="Sécurité" {{ $charge->rubrique == "Sécurité" ? "selected" : "" }}>Sécurité</option>
                <option value="Jardinage" {{ $charge->rubrique == "Jardinage" ? "selected" : "" }}>Jardinage</option>
                <option value="Charges annexes" {{ $charge->rubrique == "Charges annexes" ? "selected" : "" }}>Charges annexes</option>
                <option value="Divers" {{ $charge->rubrique == "Divers" ? "selected" : "" }}>Divers</option>
                <option value="Salaire" {{ $charge->rubrique == "Salaire" ? "selected" : "" }}>Salaire</option>
                <option value="Plomberie" {{ $charge->rubrique == "Plomberie" ? "selected" : "" }}>Plomberie</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $charge->description }}" required>
        </div>
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" name="montant" id="montant" class="form-control" value="{{ $charge->montant }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Sélectionner un type</option>
                <option value="charge_fixe_mensuelle" {{ $charge->type == "charge_fixe_mensuelle" ? "selected" : "" }}>Charge fixe mensuelle</option>
                <option value="charge_occasionnelle" {{ $charge->type == "charge_occasionnelle" ? "selected" : "" }}>Charge occasionnelle</option>
                <option value="charge_annuelle" {{ $charge->type == "charge_annuelle" ? "selected" : "" }}>Charge annuelle</option> <!-- Nouvelle option -->
            </select>

        </div>
        <div class="form-group">
            <label for="date">Date de paiement</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $charge->date }}" required>
        </div>
        <div class="form-group">
            <label for="date">Année</label>
            <select name="annee" id="annee" class="form-control" required>
                @php
                    $currentYear = date('Y');
                    $nextYear = $currentYear + 1;
                @endphp
                @for ($year = 2018; $year < $currentYear; $year++)
                    @php
                        $yearRange = $year . '/' . ($year + 1);
                    @endphp
                    <option value="{{ $yearRange }}" {{ $charge->annee == $yearRange ? 'selected' : '' }}>
                        {{ $yearRange }}
                    </option>
                @endfor
                <option value="{{ $currentYear }}/{{ $nextYear }}" {{ $charge->annee == $currentYear.'/'.$nextYear ? 'selected' : '' }}>
                    {{ $currentYear }}/{{ $nextYear }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="recus">Reçus</label>
            <input type="file" name="recus" id="recus" class="form-control-file">
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control" required>
                <option value="non paye" {{ $charge->status == "non paye" ? "selected" : "" }}>Non payé</option>
                <option value="paye" {{ $charge->status == "paye" ? "selected" : "" }}>Payé</option>
                    </select>
                    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

  <!-- Modal -->
<div class="modal fade" id="addChargeModal" tabindex="-1" role="dialog" aria-labelledby="addChargeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addChargeLabel">Ajouter charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('charges.store') }}" enctype="multipart/form-data">
            <div class="modal-body">

                @csrf

                        <div class="form-group">
                            <label for="rubrique">Rubrique</label>
                            <select name="rubrique" id="rubrique" class="form-control" required>
                                <option value="">Sélectionner une rubrique</option>
                                <option value="Sécurité">Sécurité</option>
                                <option value="Jardinage">Jardinage</option>
                                <option value="Charges annexes">Charges annexes</option>
                                <option value="Divers">Divers</option>
                                <option value="Salaire">Salaire</option>
                                <option value="Plomberie">Plomberie</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant</label>
                            <input type="number" name="montant" id="montant" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Sélectionner un type</option>
                                <option value="charge_fixe_mensuelle">Charge fixe mensuelle</option>
                                <option value="charge_occasionnelle">Charge occasionnelle</option>
                                <option value="charge_annuelle">Charge annuelle</option> <!-- Nouvelle option -->
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="date">Date de paiement</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Année</label>
                            <select name="annee" id="annee" class="form-control" required>
                                @php
                                    $currentYear = date('Y');
                                    $nextYear = $currentYear + 1;
                                @endphp
                                @for ($year = 2018; $year < $currentYear; $year++)
                                    @php
                                        $yearRange = $year . '/' . ($year + 1);
                                    @endphp
                                    <option value="{{ $yearRange }}">{{ $yearRange }}</option>
                                @endfor
                                <option value="{{ $currentYear }}/{{ $nextYear }}" selected>{{ $currentYear }}/{{ $nextYear }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recus">Reçus</label>
                            <input type="file" name="recus" id="recus" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="non paye">Non payé</option>
                                <option value="paye">Payé</option>
                            </select>
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
