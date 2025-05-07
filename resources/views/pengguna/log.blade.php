@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Data {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Pengguna</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
 
    </div>
</div>
<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped table-bordered">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 10;">
            <tr>
                <th scope="col">User Name</th>
                <th scope="col">Device Name</th>
                <th scope="col">IP Address</th>
                <th scope="col">Login Time</th>
                <th scope="col">Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->user->nama }}</td>
                    <td>{{ $log->device_name }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>{{ $log->location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection