@extends('layouts.app', ['title' => 'Note'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-box">
                    <div class="mb-4">
                        <h4 class="mt-0 header-title" class="mb-4">Create Note</h4>
                    </div>
                    <div class="row">
                        <div class="col">
                            <textarea id="note" class="form-control" placeholder="write note in here..." style="height: 100px;"></textarea>
                            <button class="btn btn-primary mt-2" onclick="generateQr()">
                                <i class="mdi mdi-qrcode"></i>
                                Generate QR
                            </button>
                            <button class="btn btn-success mt-2" onclick="saveQr()">
                                <i class="mdi mdi-download"></i>
                                Save
                            </button>
                        </div>
                        <div class="col">
                            <div id="qrcode" style="padding: 1rem;background: #fff;display: inline-block;width: auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .btn-menu i {
            font-size: 35vh;
        }
        .btn-menu { min-width: 30vh; }
    </style>
@endpush

@push('js')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        let qrcode = new QRCode("qrcode", {
                text: "alfian",
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
                    link.download = 'qrcode.png';
                    link.href = canvas.toDataURL("image/png").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
                    link.click();
                    $('#qrcode').css('padding-right', '1rem');
                }, 500);
            });
        }
    </script>
@endpush