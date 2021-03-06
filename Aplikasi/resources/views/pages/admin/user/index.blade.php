<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
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
        <script></script>
    </x-slot>
    <div id="content">

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data User</h1>
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('adminUserCreate') }}" class="btn btn-primary"><i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($users) > 0)
                                    @foreach ($users as $index => $user)
                                        <tr class="m-auto p-auto align-middle">
                                            <td>
                                                <h6><strong>{{ $user->name }}</strong></h6>
                                            </td>
                                            <td>
                                                <h6><strong>{{ $user->email }}</strong></h6>
                                            </td>
                                            <td>
                                                @php
                                                    $level = 'Petugas';
                                                    if ($user->level == '0') {
                                                        $level = 'Admin';
                                                    }
                                                @endphp
                                                <h6><strong>{{ $level }}</strong></h6>
                                            </td>
                                            <td>
                                                <div>
                                                    <a class="btn btn-primary btn-sm my-1"
                                                        href="{{ route('adminUserEdit', ['id' => $user->id]) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-sm my-1"
                                                        href="{{ route('adminUserDestroy', ['id' => $user->id, 'type' => 'delete']) }}"><i
                                                            class="fas fa-trash"></i></a>
                                                    <a class="btn btn-warning btn-sm my-1"
                                                        href="{{ route('adminUserDestroy', ['id' => $user->id, 'type' => 'reset']) }}">RESET
                                                    </a>
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
