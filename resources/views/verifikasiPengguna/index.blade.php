@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">pengguna</li>
                <li class="breadcrumb-item active" aria-current="page">Administrator</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        {{-- <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>
        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Print" data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div> --}}

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4><span class="ti ti-key"></span>Daftar Verifikasi Pengguna</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Nama Lengkap</th>
                        <th class="bg-light-400">Email</th>
                        <th class="bg-light-400">Status Pengguna</th>
                        <th class="bg-light-400"><span class="ti ti-key"></span> Permission</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($users as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                           {{ $item->nama }}
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Butuh Verifikasi</span>
                        </td>
                        <td> <span class="badge badge-soft-primary d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Role : {{ $item->role }}</span></td>
                        <td>
                           <a href="{{ route('verifikasiUpdate',$item->nomor) }}" type="submit" class="btn btn-success btn-sm"><span class="ti ti-checks"></span> Verifikasi </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

@endsection
