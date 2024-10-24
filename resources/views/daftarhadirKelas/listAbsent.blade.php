@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
    </div>
</div>
{{-- End Header --}}

<div class="card">
    <div class="card-body m-0 p-0">
        <table class="table table-striped">
            <thead>
                <tr>

                    <td class="border text-center" width="30%"><p>Nama Mata Pelajaran</p></td>
                    <td class="border text-center"  width="50%"><p>Guru Ajar</p></td>
                    <th class="border text-center">H</th>
                    <th class="border text-center">S</th>
                    <th class="border text-center">I</th>
                    <th class="border text-center">A</th>
                </tr>

            </thead>
            <tbody>

                @foreach ($mapel as $item )

                        <td class="border">{{ $item->mata_pelajaran->nama }}</td>
                        <td class="border">{{ $item->guru->nama }}</td>
                        <td class="border text-center">
                        @php
                            $hadirCount = $hadir->where('id_mapel', $item->id_mapel)->where('status', 'H')->count();
                        @endphp
                        <p>{{ $hadirCount }}</p>
                        </td>
                        <td class="border text-center">
                        @php
                            $hadirCount = $hadir->where('id_mapel', $item->id_mapel)->where('status', 'S')->count();
                        @endphp
                        <p>{{ $hadirCount }}</p>
                        </td>
                        <td class="border text-center">
                        @php
                            $hadirCount = $hadir->where('id_mapel', $item->id_mapel)->where('status', 'I')->count();
                        @endphp
                        <p>{{ $hadirCount }}</p>
                        </td>
                        <td class="border text-center">
                        @php
                            $hadirCount = $hadir->where('id_mapel', $item->id_mapel)->where('status', 'A')->count();
                        @endphp
                        <p>{{ $hadirCount }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
