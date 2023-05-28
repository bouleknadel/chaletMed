@extends('layouts.master')


@section('title')
Bilan
@endsection

@php
$selectedYear = isset($_GET['annee']) ? $_GET['annee'] : $current_year;
@endphp

@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('titre')
<h3 class="card-title font-weight-bold" style="font-size: 24px;">BILAN ANNUEL DE L'ANNÉE {{ $selectedYear }}/{{$selectedYear +1 }}</h3>
@endsection



@section('title_page')
Bilan
@endsection


@section('title_page2')

@endsection



@section('content2')
  <section class="content">
    <div class="row mb-3">
        <div class="col-md-4">
            <form action="" method="GET">
                <div class="input-group">
                    <select class="form-control" name="annee">
                        @for ($year = 2018; $year <=  $current_year ; $year++)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}/{{ $year+1 }}</option>
                        @endfor
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid ">
      <div class="row">

        <div class="col-md-6">
          <div class="card">
            @php
            $totalCharge = 0 ;
            @endphp

            <div class="card-body">
              <table id="table-actifs" class="table table-bordered table-striped tablebilan">
                <thead>
                    <tr>
                        <th class="bg-success"> Actif</th>
                        <th class="bg-success">Total actif</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Montant payé dans l'année en cours ({{ date('Y') }})</td>
                      <td class="bg-success text-white font-weight-bold" style="opacity: 0.8;">{{ $cotisationsPayeesAnneeEnCours }} DH</td>
                    </tr>
                    <tr>
                      <td>Montant non payé dans l'année en cours ({{ date('Y') }})</td>
                      <td class="bg-success text-white font-weight-bold" style="opacity: 0.8;">{{ $cotisationsNonPayeesAnneeEnCours }} DH</td>
                    </tr>
                    @foreach ($montantsNonPayesParAnnee as $annee => $montantNonPaye)
                      <tr>
                        <td>Montant non payé en ({{ $annee }})</td>
                        <td class="bg-success text-white font-weight-bold" style="opacity: 0.8;">{{ $montantNonPaye }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td>Montant partiellement payé dans l'année en cours ({{ date('Y') }})</td>
                      <td class="bg-success text-white font-weight-bold" style="opacity: 0.8;">{{ $cotisationsPartiellesAnneeEnCours }} DH</td>
                    </tr>
                    <tr>
                      <td>Montant en cours de validation dans l'année en cours ({{ date('Y') }})</td>
                      <td class="bg-success text-white font-weight-bold" style="opacity: 0.8;">{{ $cotisationsEnCoursValidationAnneeEnCours }} DH</td>
                    </tr>
                    <tr>
                        @php
                        $totalActif = $cotisationsPayeesAnneeEnCours + $cotisationsPartiellesAnneeEnCours ;
                       @endphp
                      <td>Total</td>
                      <td class="bg-success text-white font-weight-bold larger-size" style="opacity: 0.8; font-size: 18px;">{{ $totalActif }} DH</td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <table id="table-passifs" class="table table-bordered table-striped tablebilan">
                <thead>
                    <tr>
                        <th class="bg-danger"> Passif</th>
                        <th class="bg-danger">Total passif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chargesRubriquesMontants as $chargeRubriqueMontant)
                    <tr>
                        <td>{{ $chargeRubriqueMontant->rubrique }}</td>
                        <td class="bg-danger text-white font-weight-bold" style="opacity: 0.8;">{{ $chargeRubriqueMontant->total }} DH</td>
                    </tr>
                    @php
                    $totalCharge +=  $chargeRubriqueMontant->total ;
                @endphp
                @endforeach
                <tr>
                    <td>Total</td>
                    <td class="bg-danger text-white font-weight-bold larger-size" style="opacity: 0.8; font-size: 18px;">{{$totalCharge}} DH</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 mt-0 ">
        <div class="card">
          <div class="card-body">

            <table id="table-passifs" class="table table-bordered table-striped tablebilan">
              <thead>
                <tr>
                  <th colspan="2" style="font-size: 18px ; font-weight : 700 ;">RÉSULTAT NET D'EXPLOITATION</th>
                  <th colspan="2" style="background-color: {{ ($totalActif - $totalCharge) >= 0 ? 'green' : 'red' }}; font-size: 20px;" class="text-white font-weight-bold">
                    @if(($totalActif - $totalCharge) >= 0)
                      <i class="fas fa-arrow-up mr-2" style="color: rgb(255, 255, 255);"></i>
                    @else
                      <i class="fas fa-arrow-down mr-2" style="color: rgb(255, 255, 255);"></i>
                    @endif
                    {{ abs($totalActif - $totalCharge) }} DH
                  </th>
                </tr>
              </thead>
            </table>
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
