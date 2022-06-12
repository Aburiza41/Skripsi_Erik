<x-app-layout>
    <x-slot name="title">
        {{ __('Admin | Validasi Pekerjaan') }}
    </x-slot>
    <x-slot name="headerLink">
        <!-- Custom styles for this page -->
        <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin="" />
        <style>
            #map,
            #mapLayout {
                height: 600px;
            }
        </style>
    </x-slot>
    <x-slot name="footerScript">
        <!-- Page level plugins -->
        <script src="{{ asset('assets') }}/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('assets') }}/js/demo/datatables-demo.js"></script>

        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
                integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
                crossorigin=""></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(document).ready(function() {
                if ({{ Illuminate\Support\Js::from($errors->any()) }}) {

                    $({{ Illuminate\Support\Js::from($errors->all()) }}).each(function(i, val) {
                        swal({
                            title: "Warning",
                            text: val,
                            icon: "warning",
                        });
                    })

                }
                if ({{ Illuminate\Support\Js::from(session()->get('success')) }}) {
                    swal({
                        title: "Good Job",
                        text: {{ Illuminate\Support\Js::from(session()->get('success')) }},
                        icon: "success",
                    });
                    {{ Illuminate\Support\Js::from(session()->forget('success')) }}
                }

            });
        </script>
    </x-slot>
    <div id="content">

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Pengukurang Bidang Tanah</h1>
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>NIB</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>NIB</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($guestLands) > 0)
                                    @foreach ($guestLands as $index => $guestLand)
                                        <tr class="m-auto p-auto">
                                            <td>{{ $guestLand->nama_pemilik }}</td>
                                            <td>{{ $guestLand->nomor_sertifikat }}</td>
                                            <td>{{ $guestLand->nib }}</td>
                                            <td>
                                                <div>
                                                    <h6>Desa
                                                        <small><strong>{{ $guestLand->desa }}</strong></small>
                                                    </h6>
                                                    <h6>Kecamatan
                                                        <small><strong>{{ $guestLand->kecamatan }}</strong></small>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($guestLand->status_proses)
                                                    @case(0)
                                                        <small class="py-3">Pendaftaran Permohon</small>
                                                    @break

                                                    @case(1)
                                                        <small class="py-3">Pemilihan Petugas</small>
                                                    @break

                                                    @case(2)
                                                        <small class="py-3">Pengukuran Bidang</small>
                                                    @break

                                                    @case(3)
                                                        <small class="py-3">Pengerjaan Dokumen</small>
                                                    @break

                                                    @case(4)
                                                        <small class="py-3">Pekerjaan Selesai</small>
                                                    @break
                                                @endswitch
                                                @php
                                                    $progres = ($guestLand->status_proses * 100) / 6;
                                                @endphp

                                                <div class="progress mb-4">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ $progres }}%"
                                                        aria-valuenow="{{ $progres }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="mr-2">
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('adminGuestLandShow', ['id' => $guestLand->id]) }}"><i
                                                                class="fas fa-eye"></i></a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('adminValidasiPekerjaanEdit', ['id' => $guestLand->id]) }}"><i
                                                                class="fas fa-edit"></i></a>
                                                    </div>
                                                    <form class="mr-2"
                                                        action="{{ route('adminValidasiPekerjaanUpdate', ['id' => $guestLand->id, 'type' => 'selesai']) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="number" id="status_proses" name="status_proses"
                                                            value="{{ $guestLand->status_proses + 1 }}"
                                                            class="d-none form-control">
                                                        <button type="submit" class="btn btn-primary btn-sm "><i
                                                                class="fas fa-check"></i></button>
                                                    </form>

                                                    {{-- <a class="btn btn-primary btn-sm my-1"
                                                        href="{{ route('adminPengukuranBidangUpdate', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-edit"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
