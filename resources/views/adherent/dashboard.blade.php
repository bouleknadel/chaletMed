@extends('layouts.master-user')


@section('title')
    Dashboard
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection



@section('title_page')
    Dashborad
@endsection


@section('title_page2')
    liste cotisations
@endsection



@section('content2')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <h3 class="card-title ">Table des cotisations</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12 ">
                                <form action="{{ route('adherent.dashboard') }}" method="GET" class="filter-form">
                                    <div class="row">
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="select-year">Année :</label>
                                                <select id="select-year" class="form-control" name="year">
                                                    <option value="" disabled
                                                        {{ empty($selectedYear) ? 'selected' : '' }}>Toutes les années
                                                    </option>
                                                    @for ($year = 2018; $year <= $current_year; $year++)
                                                        <?php $yearNext = $year + 1; ?>
                                                        <option value="{{ $year }}"
                                                            {{ $selectedYear == $year ? 'selected' : '' }}>
                                                            {{ $year . '/' . $yearNext }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>


                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="select-letter">N° du chalet :</label>
                                                <select id="select-letter" class="form-control" name="letter">
                                                    <option value="" selected disabled>Toutes les lettres</option>
                                                    <option value="A" {{ $selectedLetter == 'A' ? 'selected' : '' }}>A
                                                    </option>
                                                    <option value="B" {{ $selectedLetter == 'B' ? 'selected' : '' }}>B
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="select-status">Statut de paiement :</label>
                                                <select id="select-status" class="form-control" name="status">
                                                    <option value="" selected disabled>Tous les statuts de paiement
                                                    </option>
                                                    <option value="payé"
                                                        {{ $selectedStatus == 'payé' ? 'selected' : '' }}>Payé</option>
                                                    <option value="partiellement payé"
                                                        {{ $selectedStatus == 'partiellement payé' ? 'selected' : '' }}>
                                                        Partiellement payé</option>
                                                    <option value="non payé"
                                                        {{ $selectedStatus == 'non payé' ? 'selected' : '' }}>Non payé
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center my-2 ff">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block"
                                                style="font-size: 17px; font-weight : 600 ;">Filtrer</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                        <th>Année </th>
                                        <th>Status</th>
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
                                                $annee = $cotisation->annee;
                                                $anneeplus = $cotisation->annee + 1;
                                            @endphp
                                            @if ($annee)
                                                <td class="text-bold">{{ $annee }}/{{ $anneeplus }}</td>
                                            @else
                                                <td>pas d'année </td>
                                            @endif
                                            <td
                                                class="@if ($cotisation->status == 'payé') text-success @elseif($cotisation->status == 'partiellement payé') text-info @else text-danger @endif">
                                                <strong>
                                                    @if ($cotisation->status == 'payé')
                                                        <i class="fas fa-check-circle"></i> Payé
                                                    @elseif($cotisation->status == 'partiellement payé')
                                                        <i class="fas fa-exclamation-circle"></i> Partiellement payé
                                                    @else
                                                        <i class="fas fa-times-circle"></i> Non payé
                                                    @endif
                                                </strong>
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
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "dom": '<"toolbar-left"f>rtip',
            });
        });
    </script>
@endsection
