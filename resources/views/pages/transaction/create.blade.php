@extends('layouts.app', ['title' => 'Create Transaction'])

@section('content')
    <div class="row">
        <div class="col-8">
                <div class="card-box table-responsive">
                    <div class="mb-4">
                        <h4 class="mt-0 header-title" style="display: inline-block;">Medcine List</h4>
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
        <div class="col-4">
            <div class="card-box">
                <h4 class="header-title">
                    <i class="mdi mdi-cart"></i>
                    Cart
                </h4>
                <hr>
                <div v-for="(item, i) in carts" :key="i">
                    <div>
                        <div class="mb-1"><b>@{{ item.name }}</b></div>
                        x <input type="number" min="1" style="width: 50px;" v-model="item.stock" :max="item.max">
                        Rp@{{ item.price*item.stock }}
                    </div>
                    <hr>
                </div>
                <div v-if="carts.length == 0" class="text-center">
                    <b>No item found.</b><hr>
                </div>
                <div>
                    <b>Total : Rp @{{ totalPriceCart }}</b>
                </div>
                <form action="{{ route('transaction.store') }}" method="POST" id="form-cart">
                    @csrf
                    <input type="hidden" name="cart">
                    <input type="text" name="patient" class="form-control mb-1" placeholder="Patient name..." required>
                    <button @click.prevent="submitCart" :disabled="carts.length == 0" class="btn btn-success btn-block">Process</button>
                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
<!-- third party css -->
<link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<!-- third party css end -->    
@endpush

@push('js')
<!-- third party js -->
<script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/vue.js') }}"></script>
<!-- third party js ends -->
<script>
const vm = new Vue({
    el: '#app',
    data: {
        carts: []
    },
    computed: {
        totalPriceCart: function() {
            let total = 0;
            this.carts.forEach(e => total += e.stock*e.price);
            return total;
        }
    },
    methods : {
        addToCart: function (id, name, price, max){
            let s = this.carts.find(e => e.id === id);
            if (typeof s !== 'undefined') return s.stock++;
            this.carts.push({ id, name, price, max, stock: 1 });
        },
        submitCart: function () {
            if ($('form#form-cart input[name=patient]').val() == "") return alert("patient name required..");
            $('form#form-cart input[name=cart]').val( JSON.stringify(this.carts) );
            $('form#form-cart').submit();
        }
    }
});

function addToCart(id, name, price, max) {
    vm.addToCart(id, name, price, max);
}

$('#table').DataTable( {
    ajax: "{{ route('transaction.create') }}",
    processing: true,
    order: [[0, 'asc']],
    columnDefs: [ { orderable: false, targets: [5] }, ],
    columns: [
        { render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
        { data: 'name' },
        { data: 'price' },
        { data: 'stock' },
        { data: 'unit' },
        {
            data: null,
            render: (data, type, row) => `
                <div class="text-center">
                    <button class="btn btn-sm btn-primary" onclick="addToCart(${data.id}, '${data.name}', ${data.price}, ${data.stock})">
                        <i class="mdi mdi-plus"></i>
                    </button>
                </div>
            `
        }
    ]
});
</script>
@endpush