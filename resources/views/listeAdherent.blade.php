@extends('layouts.master')


@section('title')
List des utilisateurs
@endsection



@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection



@section('title_page')
Uitlisateurs
@endsection


@section('title_page2')

@endsection



@section('content2')



@if (session('successedit'))
    <div class="alert alert-success w-75">
        <i class="fas fa-edit"></i>
        {{ session('successedit') }}
    </div>
@endif
@if (session('successdelete'))
    <div class="alert alert-success w-75">
        <i class="fas fa-trash-alt mr-2"></i>
        {{ session('successdelete') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success w-75">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger w-75">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Table des adherent</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if(Auth::user()->role != 'syndic')
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addUserModal" style="margin-bottom: 10px;">
                    <i class="fas fa-user-plus"></i> Ajouter Utilisateur
                  </button>
                @endif
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Rôle</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>N° du chalet</th>
                    <th>Numéro de téléphone</th>
                    <th>Numéro de téléphone 2</th>
                    <th>Email</th>
                    @if(Auth::user()->role != 'syndic')
                    <th>Action</th>
                    @endif

                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->numero_devilla }}</td>
                        <td>{{ $user->numero_de_telephone }}</td>
                        <td>{{ $user->numero_de_telephone2 }}</td>
                        <td>{{ $user->email }}</td>
                        @if(Auth::user()->role != 'syndic')
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $user->id }}"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline-block" class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                      @endif
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
  <!-- Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Ajouter Utilisateur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('users.store') }}">
          <div class="modal-body">
            <!-- Contenu du formulaire d'ajout d'utilisateur -->
            @csrf


              <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-control" id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">Utilisateur</option>
                    <option value="syndic">Syndic</option>
                    <!-- Ajoutez les autres options de rôle ici -->
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Nom</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">lastname</label>
                <input type="text" class="form-control" name="lastname" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Numero chalet</label>
                <input type="text"  name="numero_devilla" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">numero_de_telephone</label>
                <input type="text" class="form-control" name="numero_de_telephone" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">numero_de_telephone2</label>
                <input type="text" class="form-control" name="numero_de_telephone2" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control"name="email" id="exampleInputEmail1" placeholder="Enter email">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>

            <!-- /.card-body -->
            <!-- ... -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@foreach ($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Modifier l'utilisateur {{ $user->name }} {{ $user->lastname }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="form-group">
                        <label for="role{{ $user->role }}">Rôle</label>
                        <select class="form-control" id="role{{ $user->role }}" name="role">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="syndic" {{ $user->role == 'syndic' ? 'selected' : '' }}>Syndic</option>
                            <!-- Ajoutez les autres options de rôle ici -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name{{ $user->id }}">Nom</label>
                        <input type="text" name="name" class="form-control" id="name{{ $user->id }}" value="{{ $user->name }}" placeholder="Nom">
                    </div>
                    <div class="form-group">
                        <label for="lastname{{ $user->id }}">Prénom</label>
                        <input type="text" name="lastname" class="form-control" id="lastname{{ $user->id }}" value="{{ $user->lastname }}" placeholder="Prénom">
                    </div>
                    <div class="form-group">
                        <label for="numero_devilla{{ $user->id }}">Numéro de villa</label>
                        <input type="text" name="numero_devilla" class="form-control" id="numero_devilla{{ $user->id }}" value="{{ $user->numero_devilla }}" placeholder="Numéro de villa">
                    </div>
                    <div class="form-group">
                        <label for="numero_de_telephone{{ $user->id }}">Numéro de téléphone</label>
                        <input type="text" name="numero_de_telephone" class="form-control" id="numero_de_telephone{{ $user->id }}" value="{{ $user->numero_de_telephone }}" placeholder="Numéro de téléphone">
                    </div>
                    <div class="form-group">
                        <label for="numero_de_telephone2{{ $user->id }}">Numéro de téléphone 2</label>
                        <input type="text" name="numero_de_telephone2" class="form-control" id="numero_de_telephone2{{ $user->id }}" value="{{ $user->numero_de_telephone2 }}" placeholder="Numéro de téléphone 2">
                    </div>
                    <div class="form-group">
                    <label for="email{{ $user->id }}">Adresse email</label>
                    <input type="email" name="email" class="form-control" id="email{{ $user->id }}" value="{{ $user->email }}" placeholder="Adresse email">
                    </div>
                    <div class="form-group">
                    <label for="password{{ $user->id }}">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password{{ $user->id }}" placeholder="Mot de passe">
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                    </form>
                    </div>
                    </div>

                    </div>
                    @endforeach
                    <!-- End Modal -->

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

