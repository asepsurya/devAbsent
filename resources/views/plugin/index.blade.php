@extends('layout.main')
@section('css')
<style>
    .table td {
        word-wrap: break-word;
        white-space: normal;
    }
    .nav-link {
        font-size: 0.875rem;
        color: #000000;
        text-decoration: none;
    }

</style>
@endsection
@section('container')
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Plugin dan Fitur Manajemen</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Plugin</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div >
            <a href="{{ route('pluginImportForm') }}"  rel="noopener noreferrer"><button class="btn btn-primary ">Tambah Plugin Baru</button></a>
        </div>
    </div>
</div>


    <div class="d-flex mt-3 justify-content-between">
        <ul class="nav mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="/plugin?data=all">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('data') == 'active' ? 'active' : '' }}" href="/plugin?data=active">
                    Aktif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('data') == 'nonactive' ? 'active' : '' }}" href="/plugin?data=nonactive">
                    Nonaktif
                </a>
            </li>
        </ul>

        <div class="col-md-4">
            <input type="text" id="searchPlugin" class="form-control" placeholder="Cari plugin yang terinstal">
        </div>
    </div>
    <div class="table-responsive">
    <table class="table " id="pluginTable">
        <thead>
            <tr>
                <th class="border">
                   #
                </th>
                <th width="40%" class="border">Plugin</th>
                <th class="border">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @php $no =1 ;@endphp
            @if ($data->count())

            @foreach ($data as $item )
            <tr >
                <td class="border">
                    {{ $no++ }}
                </td >
                <td class="plugin-name" class="border"><strong>{{ $item->name }}</strong><br >
                    @if($item->status == 1)
                        <a href="/plugin/status?class=nonactive&val={{ $item->alias}}" class="text-danger me-3">Nonaktifkan</a>
                    @else
                        <a href="/plugin/status?class=active&val={{ $item->alias}}" class="text-primary">Aktifkan</a> |
                        <a href="{{ route('deletePlugin',$item->alias) }}" class="text-danger">Hapus</a>
                    @endif

                </td>
                <td class="border">{{ $item->description }}<br>
                    <small>Versi {{ $item->version }} | Oleh <a href="#" class="text-primary">{{ $item->auth }}</a> </td>
            </tr>

            @endforeach
            @else
               <tr class="border">
                    <td colspan="3">
                        <div class="d-flex justify-content-center">
                            Plugin belum ada yang dipasang
                        </div>

                    </td>
               </tr>
            @endif
        </tbody>
    </table>
    </div>

    <script>
        document.getElementById("searchPlugin").addEventListener("keyup", function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll("#pluginTable tbody tr");

            rows.forEach(row => {
                let pluginName = row.querySelector(".plugin-name").textContent.toLowerCase();
                if (pluginName.includes(searchValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });


    </script>
@endsection
