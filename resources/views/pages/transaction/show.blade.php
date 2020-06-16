@extends('layouts.app', ['title' => 'Transaction Detail'])

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="card-box table-responsive">
                <div class="mb-4">
                    <h4 class="mt-0 header-title" style="display: inline-block;">Information</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="p-2">
                            <form class="form-horizontal" role="form">
                                <div class="form-group row">
                                    <label class="col-sm-2  col-form-label" for="simpleinput">Patient</label>
                                    <div class="col-sm-10">
                                        <input name="name" value="{{ $transaction->patient }}" type="text" class="form-control" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-box table-responsive">
                <div class="mb-4">
                    <h4 class="mt-0 header-title" style="display: inline-block;">
                        <i class="mdi mdi-cart"></i>
                        Cart
                    </h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="table" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Stock</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($transaction->medicines as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->stock }}</td>
                                        <td>Rp {{ $item->pivot->stock*$item->pivot->price }}</td>
                                    </tr>                                    
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right pr-4">Total :</th>
                                    <th>Rp {{ $transaction->total_price }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card-box">
                <div class="mb-2">
                    <h4 class="mt-0 header-title" style="display: inline-block;">Qrcode</h4>
                </div>
                <div class="text-center">
                    <div id="qrcode" style="padding: 1rem;background: #fff;display: inline-block;width: auto;"></div>
                    <div>
                        <button class="btn btn-success mt-2" onclick="saveQr()">
                            <i class="mdi mdi-download"></i>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        let qrcode = new QRCode("qrcode", {
                text: "{{ route('link', [$transaction->id]) }}",
                width: 128,
                height: 128,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        function generateQr() {
            qrcode.makeCode($('textarea').val());
        }
        function saveQr() {
            html2canvas(document.querySelector("#qrcode")).then(canvas => {
                $('#qrcode').css('padding-right', '1.5rem');
                setTimeout(() => {
                    let link = document.createElement('a');
                    link.download = 'qrcode_transaction_{{ $transaction->id }}.png';
                    link.href = canvas.toDataURL("image/png").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
                    link.click();
                    $('#qrcode').css('padding-right', '1rem');
                }, 500);
            });
        }
    </script>
@endpush