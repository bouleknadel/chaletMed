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
              <table id="example1" class="table table-bordered table-striped" >
                <thead >
                <tr>
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
                        <td>{{ $cotisation->user->name }}</td>
                        <td>{{ $cotisation->user->lastname }}</td>
                        <td>{{ $cotisation->montant }} DH</td>
                        <td>{{ $cotisation->date }}</td>
                        <td>
                            @if($cotisation->recu_paiement)
                                <a href="{{ asset('uploads/recus/'.$cotisation->recu_paiement) }}"  download>
                                    <img src="{{ asset('uploads/recus/'.$cotisation->recu_paiement) }}" height="40" width="40" class="img-responsive" alt="recu">
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="@if($cotisation->status == 'payé') text-success @else text-danger @endif">
                            <strong>
                            @if($cotisation->status == 'payé')
                              <i class="fas fa-check-circle"></i> Payé
                            @else
                              <i class="fas fa-times-circle"></i> Non payé
                            @endif
                        </strong>
                          </td>

                        <td>
                            <a href="{{ route('cotisations.edit', $cotisation->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('cotisations.destroy', $cotisation->id) }}" method="post" style="display: inline-block" class="mt-1">
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
