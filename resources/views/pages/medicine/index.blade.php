@extends('layouts.app', ['title' => 'Medicine'])

@section('content')
    <div class="row">
        <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="mb-4">
                        <h4 class="mt-0 header-title" style="display: inline-block;">List Medicine</h4>
                        <a href="{{ route('medicine.create') }}" class="btn btn-sm btn-success float-right">New</a>
                    </div>
                    <table id="table" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Unit</th>
                            <th class="text-center">...</th>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
@stop

@push('css')
<!-- third party css -->
<link href="assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
<!-- third party css end -->    
@endpush

@push('js')
<!-- third party js -->
<script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
<script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/buttons.html5.min.js"></script>
<script src="assets/libs/datatables/buttons.flash.min.js"></script>
<script src="assets/libs/datatables/buttons.print.min.js"></script>
<script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables/dataTables.select.min.js"></script>
<script src="assets/libs/pdfmake/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/vfs_fonts.js"></script>
<!-- third party js ends -->
<script>
$('#table').DataTable( {
    ajax: "{{ route('medicine.index') }}",
    processing: true,
    order: [[0, 'asc']],
    columnDefs: [ { orderable: false, targets: [5] }, ],
    columns: [
        { render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
        { data: 'name' },
        { data: 'price' },
        { data: 'stock' },
        { data: 'unit' },
        { data: 'action' },
    ]
});
</script>
@endpush