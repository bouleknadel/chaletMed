@extends('layouts.master')


@section('title')
Liste des adherent
@endsection



@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection



@section('title_page')
Adherent
@endsection


@section('title_page2')

@endsection



@section('content2')

@if (session('successedit'))
    <div class="alert alert-success w-75">
        {{ session('successedit') }}
    </div>
@endif
@if (session('successdelete'))
    <div class="alert alert-success w-75">
        {{ session('successdelete') }}
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de villa</th>
                    <th>Numéro de téléphone</th>
                    <th>Numéro de téléphone 2</th>
                    <th>Email</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->numero_devilla }}</td>
                        <td>{{ $user->numero_de_telephone }}</td>
                        <td>{{ $user->numero_de_telephone2 }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline-block" class="mt-1">
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

