<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>
    <x-slot name="headerLink">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin="" />
        <link rel="stylesheet"
            href="{{ asset('assets/vendor/leaflet-panel-layers-master') }}/src/leaflet-panel-layers.css" />
        <style>
            #map,
            #mapLayout {
                height: 600px;
            }
        </style>
    </x-slot>
    <x-slot name="footerScript">
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
                integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
                crossorigin=""></script>
        <script src="{{ asset('assets/vendor/leaflet-panel-layers-master') }}/src/leaflet-panel-layers.js"></script>
        <script>
            const guestLands = {{ Illuminate\Support\Js::from($guestLands) }};
            const url = window.location.origin; //get base url atau domain


            // console.log(kecamatan);
            // console.log(guestLands);

            var map = L.map('map', {
                    zoom: 15,
                    center: L.latLng([0.01195500848542409, 110.9013491117639]),
                }),
                osmLayer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            map.addLayer(osmLayer);

            var baseLayers = [{
                name: "Open Street Map",
                layer: osmLayer
            }];

            const g_desa = [];
            const g_user = [];
            for (let i_desa = 0; i_desa < {{ Illuminate\Support\Js::from($desa) }}.length; i_desa++) {
                const el_desa = {{ Illuminate\Support\Js::from($desa) }}[i_desa];
                for (let i_user = 0; i_user < guestLands.length; i_user++) {
                    const el_user = guestLands[i_user];
                    if (el_user.village_id == el_desa.id) {
                        let l_user = {
                            active: false,
                            name: el_user.nama_pemilik,
                            layer: []
                        }
                        g_user.push(l_user);
                    }
                }
                let l_desa = {
                    group: el_desa.nama_desa,
                    collapsed: true,
                    layers: g_user
                }
                g_desa.push(l_desa);
            }
            var overLayers = g_desa;
            console.log(overLayers);

            var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
                //compact: true,
                //collapsed: true,
                collapsibleGroups: true
            });

            map.addControl(panelLayers);
        </script>
    </x-slot>
    <div id="content">

        <!-- Topbar -->
        @include('layouts.navbar')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xx font-weight-bold text-primary text-uppercase mb-1">
                                        Total User</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['total-user'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-3 mb-4">
                    <div class="card border-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xx font-weight-bold text-warning text-uppercase mb-1">
                                        Total Admin</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['total-admin'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-3 mb-4">
                    <div class="card border-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xx font-weight-bold text-warning text-uppercase mb-1">
                                        Total Petugas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['total-petugas'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Pengajuan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['total-pengajuan'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendaftaran
                                    </div>
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $count['pendaftaran'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pemilihan Petugas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['pemilihan-petugas'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pengukuran Bidang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['pengukuran-bidang'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pembuatan Peta Bidang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['pembuatan-peta'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pengecekan Pekerjaan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['pengecekan-pekerjaan'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pekerjaan Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $count['pekerjaan-selesai'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="map" name="map">
            </div>
        </div>
        <!-- /.container-fluid -->


    </div>
</x-app-layout>
