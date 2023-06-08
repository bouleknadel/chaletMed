@extends('layouts.master')


@section('title')
    Synthese RECOUVREMENT
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
    Recouvrement
@endsection


@section('title_page2')
@endsection



@section('content2')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <form action="{{ route('cotisations.recouvrement') }}" method="GET" class="filter-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="select-year" class="form-control" name="selectedYear">
                                        @for ($year = 2017; $year <= $current_year; $year++)
                                            <option value="{{ $year }}"
                                                {{ $selectedYear == $year ? 'selected' : '' }}>
                                                {{ $year . '/' . ($year + 1) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary ">Filtrer</button>
                            </div>

                    </form>
                </div>
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Recouvrement cotisation</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>

                                            @foreach ($annee_colunms as $annee)
                                                @php
                                                    $anneeplus = $annee + 1;
                                                @endphp
                                                @if ($selectedYear == $annee)
                                                    <th class="@if ($annee == $current_year) bg-info @else '' @endif">
                                                        {{ $annee }}/{{ $anneeplus }}</th>
                                                @else
                                                    <th class="@if ($annee == $current_year) bg-info @endif">
                                                        {{ $annee }}/{{ $anneeplus }}</th>
                                                @endif
                                            @endforeach


                                            <th class="bg-danger text-white">Total Impayés</th>

                                            <th class="bg-success text-white">Total Payés</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }} {{ $user->lastname }}
                                                    ({{ $user->numero_devilla }})</td>

                                                {{-- @php
                                                    $total = 0;
                                                    $totalPrixLocation = 0;
                                                    $totalPaye = 0;
                                                @endphp
                                                @foreach ($annee_colunms as $annee)
                                                    <td>
                                                        @foreach ($cotisations as $cotisation)
                                                            @if ($cotisation->user_id == $user->id && $cotisation->annee == $annee)
                                                                @if ($cotisation->status == 'payé')
                                                                    <span class="badge badge-success">Payé</span>
                                                                    @php
                                                                        $totalPaye += $cotisation->total_paye;
                                                                    @endphp
                                                                @elseif ($cotisation->status == 'partiellement payé')
                                                                    <span
                                                                        class="badge badge-info">{{ -$cotisation->total_impaye }}
                                                                        DH</span>
                                                                    @php
                                                                        $total += $cotisation->total_impaye;
                                                                    @endphp
                                                                @else
                                                                    @if ($cotisation->status == '' || $cotisation->status == 'non payé')
                                                                        <span class="badge badge-danger">Non payé :
                                                                            {{ -$cotisation->total_prix_location }}
                                                                            DH</span>
                                                                        @php
                                                                            $totalPrixLocation += $cotisation->total_prix_location;
                                                                        @endphp
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @endforeach --}}
                                                @foreach ($annee_colunms as $annee)
                                                    <td class="">

                                                        @if ($user["status_$annee"] == 'payé')
                                                            <span class="badge badge-success">Payé</span>
                                                        @elseif ($user["status_$annee"] == 'partiellement payé')
                                                            <span class="badge badge-warning">Part.:
                                                                {{ $user["mi_$annee"] }}
                                                                DH</span>
                                                        @else
                                                            @if ($user["status_$annee"] == '' || $user["status_$annee"] == 'non payé')
                                                                <span class="badge badge-danger">Non payé :
                                                                    {{ $user["mi_$annee"] }}
                                                                    DH</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="font-weight-bold text-danger">
                                                    {{ $user['total_impaye'] }} DH
                                                </td>

                                                <td class="font-weight-bold text-success">
                                                    {{ $user['total_paye'] }} DH
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                "lengthChange": false,
                order: [
                    [9, 'desc']
                ],
                "autoWidth": false,
                "responsive": true,
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
