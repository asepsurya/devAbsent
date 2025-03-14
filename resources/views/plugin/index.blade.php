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
    <div class="d-flex">
        <h3 class="mb-4 me-4">Plugin</h3>
        <div >
            <a href="{{ route('pluginImportForm') }}" target="_blank" rel="noopener noreferrer"><button class="btn btn-primary btn-sm">Tambah Plugin Baru</button></a>
        </div>
    </div>
    
    <ul class="nav mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Semua (2)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Nonaktif (2)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Tersedia Pembaruan (1)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Pembaruan otomatis Dinonaktifkan (2)</a>
        </li>
    </ul>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <select class="form-select select">
                <option>Tindakan Massal</option>
                <option>Aktifkan</option>
                <option>Hapus</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Terapkan</button>
        </div>
        <div class="col-md-4">
            <input type="text" id="searchPlugin" class="form-control" placeholder="Cari plugin yang terinstal">
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered" id="pluginTable">
        <thead>
            <tr>
                <th>
                    <div class="form-check form-check-md">
                        <input class="form-check-input" type="checkbox"  id="selectAll">
                    </div>
                </th>
                <th width="40%">Plugin</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="form-check form-check-md">
                        <input class="form-check-input plugin-checkbox" type="checkbox">
                    </div>
                </td>
                <td class="plugin-name"><strong>Antispam Akismet: Perlindungan Spam</strong><br><a href="#" class="text-primary">Aktifkan</a></td>
                <td>Digunakan oleh jutaan orang, Akismet sangat mungkin adalah cara terbaik di dunia untuk <strong>melindungi blog Anda dari spam</strong>. Membuat situs Anda terlindungi bahkan saat Anda tidur.<br>
                    <small>Versi 5.3.5 | Oleh <a href="#">Automattic - Tim Antispam</a> | <a href="#">Tampilkan rincian</a></small></td>
            </tr>
            <tr>
                <td>
                    <div class="form-check form-check-md">
                        <input class="form-check-input plugin-checkbox" type="checkbox">
                    </div>
                </td>
                <td class="plugin-name"><strong>Hello Dolly</strong><br><a href="#" class="text-primary">Aktifkan</a></td>
                <td>Ini bukan hanya sebuah plugin, namun mewakili harapan dan antusiasme dari sebuah generasi utuh yang dirangkum oleh lagu terkenal.<br>
                    <small>Versi 1.7.2 | Oleh <a href="#">Matt Mullenweg</a> | <a href="#">Tampilkan rincian</a></small></td>
            </tr>
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

        document.getElementById("selectAll").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".plugin-checkbox");
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
